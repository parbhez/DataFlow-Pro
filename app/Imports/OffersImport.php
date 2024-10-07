<?php

namespace App\Imports;

use App\Constants\Status;
use App\Models\Category;
use App\Models\Location;
use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rules\File;


class OffersImport implements ToModel, WithHeadingRow, WithValidation
{
    protected $imageFilenames;

    // Constructor to pass the image filenames from the controller
    public function __construct(array $imageFilenames)
    {
        $this->imageFilenames = $imageFilenames;
    }

    /**
     * @param array $row The row data from the excel file
     *
     * @return Offer|null
     */
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            // Create a new Offer instance using the validated row data
            $offer = new Offer([
                'title'       => $row['title'] ?? 'Test',
                'price'       => $row['price'] ?? '0.00',
                'description' => $row['description'] ?? 'Test description',
                'author_id'   => auth()->user()->id, // Get the logged-in user's ID
                'status'      => $row['status'] ?? Status::DRAFT, // Default to DRAFT status if not provided
            ]);


            // Save the offer to the database
            $offer->save();

            // Check if categories are provided and attach them to the offer
            if (!empty($row['categories'])) {
                // Assuming categories are provided as a comma-separated string
                $categories = array_map('trim', explode(',', $row['categories']));
                $categoryIds = []; // Store category IDs to attach

                foreach ($categories as $categoryName) {
                    // Find or create the category and get its ID
                    // $category = Category::firstOrCreate(['title' => $categoryName]);

                    // Find the category by title
                    $category = Category::where('title', $categoryName)->first();

                    // If it doesn't exist, create a new category
                    if (!$category) {
                        $category = new Category(['title' => $categoryName]);
                        $category->save(); // Save the new category to the database
                    }

                    $categoryIds[] = $category->id; // Collect the category IDs
                }

                // Sync categories to the offer using the collected category IDs
                $offer->categories()->sync($categoryIds);
            }

            // Check if locations are provided and attach them to the offer
            if (!empty($row['locations'])) {
                // Assuming locations are provided as a comma-separated string
                $locations = array_map('trim', explode(',', $row['locations']));
                $locationIds = []; // Store Location IDs to attach

                foreach ($locations as $locationName) {
                    // Find or create the location and get its ID
                    $location = Location::firstOrCreate(['title' => $locationName]);
                    $locationIds[] = $location->id; // Collect the location IDs
                }

                // Sync locations to the offer using the collected location IDs
                $offer->locations()->sync($locationIds);
            }

            // Attach the image to the offer using Spatie Media Library
            if (!empty($this->imageFilenames)) {
                $imagePath = array_shift($this->imageFilenames); // Get the next image path from the array
                $offer->addMedia(storage_path('app/public/' . $imagePath))->toMediaCollection();
            }

            return $offer;
        }, 5); // Retry the transaction up to 5 times in case of deadlock
    }

    /**
     * Validation rules for the import.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',                      // Title is required, must be a string, and has a max length of 255 characters
            'price' => 'required|numeric|min:0',                      // Price is required, must be numeric, and cannot be less than 0
            'description' => 'nullable|string',                        // Description is optional, must be a string if provided
            'image' => ['nullable', File::image()->max('10mb')],    // Image is optional, must be an image file and max size of 10MB
            'categories' => 'required|string',                   // Categories are required, must be an string, and must contain at least one item
            'locations' => 'required|string',                    // Locations are required, must be an array, and must contain at least one item
        ];
    }
}
