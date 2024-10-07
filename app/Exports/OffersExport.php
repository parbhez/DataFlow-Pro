<?php

namespace App\Exports;

use App\Models\Offer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents; // Import WithEvents
use Maatwebsite\Excel\Events\AfterSheet; // Import AfterSheet
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class OffersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
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
            null, // Placeholder for image
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
        return (new Drawing())
            ->setName('Offer Image')
            ->setDescription('Offer Image')
            ->setPath($imagePath) // Full path to the image
            ->setWidth(30)  // Set width to scale the image
            ->setHeight(30); // Set height to scale the image (adjust as needed)
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
            'Categories',
            'Locations',
            'Status',
            'DateTime',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Loop through the offers and add images
                foreach ($this->offers as $index => $offer) {
                    $imagePath = public_path($offer->getExcelImageUrlAttribute());
                    if (file_exists($imagePath)) {
                        $drawing = $this->getImageDrawing($imagePath);
                        $drawing->setCoordinates('D' . ($index + 2)); // Adjust 'D' to the correct column for images
                        $drawing->setWidth(30);  // Set image width to 30px
                        $drawing->setHeight(30); // Set image height to 30px
                        $drawing->setWorksheet($event->sheet->getDelegate());
                    } else {
                        \Log::warning('Image not found for offer ID ' . $offer->id . ': ' . $imagePath);
                    }
                }

                // Set auto-size for all columns
                $sheet = $event->sheet->getDelegate();
                foreach (range('A', 'H') as $columnID) { // Assuming columns A to H are used
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}
