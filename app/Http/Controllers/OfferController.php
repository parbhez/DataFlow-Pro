<?php

namespace App\Http\Controllers;

use App\Common\Common;
use App\Http\Requests\StoreOfferRequest;
use App\Models\Category;
use App\Models\Location;
use App\Models\Offer;
use App\Services\OfferService;
use Illuminate\Http\Request;
use App\Exports\OffersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OffersImport;
use Illuminate\Support\Facades\Log;


class OfferController extends Controller
{

    public function BulkImportOffer(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            //'file' => 'required|mimes:xlsx,xls|max:10240', // File must be xlsx or xls, max size 10MB
            'file' => 'required|max:10240', // File must be xlsx or xls, max size 10MB
        ]);

        $file = $request->file('file');

        // Ensure the file is an Excel file
        if (!in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            return redirect()->back()->with('error', 'Please upload a valid Excel file xlsx,xls .');
        }

        try {
            // Upload images and get their filenames
            $imageFilenames = Common::fileUpload($file);

            // Pass the image filenames to the import class
            Excel::import(new OffersImport($imageFilenames), $file);

            Log::info('Offers imported successfully');

            return redirect()->back()->with('success', 'Offers imported successfully!');
        } catch (\Exception $e) {
            Log::error('Excel import failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, OfferService $offerService)
    {

        $this->authorize('viewAny', Offer::class);

        $categories = Category::orderBy('title')->get();
        $locations = Location::orderBy('title')->get();

        // Set default limit if not provided
        $limit = $request->input('limit', PAGINATE_LIMIT); // Default to 10 if no limit is provided

        $offers = $offerService->get($request->query(), $limit, $isMyOffer = false);

        // Check if the request is AJAX
        if ($request->ajax()) {
            return view('offers.offer-table', compact('offers', 'categories', 'locations'))->render();
        }

        return view('offers.index', compact('offers', 'categories', 'locations'));
    }

    public function myOffers(Request $request, OfferService $offerService)
    {
        $this->authorize('viewMy', Offer::class);

        $categories = Category::orderBy('title')->get();
        $locations = Location::orderBy('title')->get();

        // Set default limit if not provided
        $limit = $request->input('limit', PAGINATE_LIMIT); // Default to 10 if no limit is provided

        $offers = $offerService->get($request->query(), $limit, $isMyOffer = true);

        // Check if the request is AJAX
        if ($request->ajax()) {
            return view('offers.offer-table', compact('offers', 'categories', 'locations'))->render();
        }

        return view('offers.index', compact('offers', 'categories', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Offer::class);

        $categories = Category::orderBy('title')->get();
        $locations = Location::orderBy('title')->get();
        return view('offers.create', compact('categories', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request, OfferService $offerService)
    {
        // Check if the user is authorized to create an offer
        $this->authorize('create', Offer::class);

        try {
            // Call the service to store the offer with validated data
            $offerService->store(
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );

            // throw new \Exception('Offer not created');

            // Redirect back with success message
            return redirect()->back()->with(['success' => 'Offer Created!']);
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Error creating offer: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        return view('offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update', $offer);

        $categories = Category::orderBy('title')->get();
        $locations = Location::orderBy('title')->get();
        return view('offers.edit', compact('offer', 'categories', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreOfferRequest $request, Offer $offer, OfferService $offerService)
    {
        // Check if the user is authorized to update an offer
        $this->authorize('update', $offer);

        try {
            // Call the service to update the offer with validated data
            $offerService->update(
                $offer,
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );

            // throw new \Exception('Offer not created');

            // Redirect back with success message
            return redirect()->back()->with(['success' => 'Offer updated!']);
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Error creating offer: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer, OfferService $offerService)
    {
        $offerService->destroy($offer);
        return response('Offer deleted');
    }

    /**
     * selected offer wise generate pdf file
     */
    public function generateOfferPdf(Request $request, OfferService $offerService)
    {
        try {
            // Set default limit if not provided
            $limit = $request->input('limit', PAGINATE_LIMIT); // Default to 10 if no limit is provided

            if (auth()->user()->isAdmin()) {
                $offers = $offerService->get($request->query(), $limit);
            } else {
                $offers = $offerService->get($request->query(), $limit, $isMyOffer = true);
            }
            // Generate PDF using the helper
            $mpdf = initializeMpdf();
            //return $html = view("pdf.offer", compact('offers'));
            $html = view("pdf.offer", compact('offers'))->render();
            $mpdf->WriteHTML($html);
            $mpdf->Output('offer.pdf', 'I');
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('PDF generation failed: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'Something went wrong. Please try again.']);
        }
    }


    public function generateOfferExcel(Request $request, OfferService $offerService)
    {


        // $offer = Offer::find(523);
        // echo "<pre>";
        // print_r($offer->image_url);
        // echo "<pre>";
        // print_r($offer->excel_image_url);
        // exit();

        try {
            // Set default limit if not provided
            $limit = $request->input('limit', PAGINATE_LIMIT);
            // Get offers based on user role
            if (auth()->user()->isAdmin()) {
                $offers = $offerService->get($request->query(), $limit);
            } else {
                $offers = $offerService->get($request->query(), $limit, true);
            }

            // Return the Excel file as a download
            return Excel::download(new OffersExport($offers), 'offers.xlsx');
        } catch (\Exception $e) {
            // Log the error message for debugging
            \Log::error('Excel generation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
