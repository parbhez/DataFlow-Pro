<?php

namespace App\Exports;

use App\Models\Offer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing; // Import Drawing

class OffersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{

    protected $offers;
    protected $index = 0; // Initialize the index property

    public function __construct($offers)
    {
        $this->offers = $offers;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->offers;

        // return $this->offers->map(function ($q, $index) {

        //     return [
        //         $q->sl = ++$index,
        //         $q->author_id = $q->author->name,
        //         $q->title = $q->title,
        //         $q->image = $q->image,
        //         $q->price = $q->price,
        //         $q->category = getTitles($q->categories),
        //         $q->location = getTitles($q->locations),
        //         $q->status = $q->status,
        //         $q->datetime = date('Y-m-d h:i:s a', strtotime($q->created_at)),
        //     ];
        // });
    }

    /**
     * @param Offer $offer
     * @return array
     */
    public function map($offer): array
    {
        $this->index++; // Increment the index for each offer

        return [
            $this->index, // Use the class property for sequential number
            $offer->author->name, // Author name
            $offer->title, // Offer title
            $offer->getImageUrlAttribute() ? $this->getImageDrawing(public_path($offer->getImageUrlAttribute())) : null, // Image
            $offer->price, // Offer price
            getTitles($offer->categories), // Categories (formatted)
            getTitles($offer->locations), // Locations (formatted)
            $offer->status, // Offer status
            date('Y-m-d h:i:s a', strtotime($offer->created_at)), // Creation date formatted
        ];
    }

    /**
     * Get the image drawing object for the offer
     */
    private function getImageDrawing($imagePath)
    {
        $drawing = new Drawing();

        $drawing->setName('Offer Image')
            ->setDescription('Offer Image')
            ->setPath($imagePath) // Full path to the image
            ->setHeight(90); // Set height to scale the image (adjust as needed)

        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Header row
        ];
    }

    public function headings(): array
    {
        return [
            '#SL',
            'Created By',
            'Title',
            'Image',
            'Price',
            'Category',
            'Location',
            'Status',
            'DateTime',
        ];
    }
}
