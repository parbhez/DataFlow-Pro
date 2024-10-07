<?php

namespace App\Common;

use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Common
{
    public static function fileUpload($file)
    {
        // Load the Excel file
        $spreadsheet = IOFactory::load($file);

        $imageFilenames = [];

        // Extract images from the Excel file
        foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
            $zipReader = fopen($drawing->getPath(), 'r');
            $imageContents = '';
            while (!feof($zipReader)) {
                $imageContents .= fread($zipReader, 1024);
            }
            fclose($zipReader);

            $extension = $drawing->getExtension() ?? 'png'; // Default to 'png' if extension is null
            $myFileName = uniqid() . '-' . time() . '.' . $extension; // Generate unique filename

            // Store the image in the public storage
            Storage::disk('public')->put($myFileName, $imageContents);

            // Store the image filenames for further use in the import
            $imageFilenames[] = $myFileName; // Return the file names
        }

        return $imageFilenames; // Make sure to return the array
    }
}
