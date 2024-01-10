<?php

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$outputFile = $root . 'output' . DIRECTORY_SEPARATOR . 'updated_pricing.csv';
require $root . 'vendor/autoload.php';

use App\Processor;

// Include the view for the upload form
include_once $root . 'view/uploadForm.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_FILES['newPricingFile']['error'] === UPLOAD_ERR_OK && $_FILES['oldPricingFile']['error'] === UPLOAD_ERR_OK) {
        // Further validation (file type, size, etc.)

        $processor = new Processor();
        $processor->processFiles($_FILES['newPricingFile']['tmp_name'], $_FILES['oldPricingFile']['tmp_name'], $_POST['suffix'], $outputFile);

        echo "Processing completed. Check the output file.";
    } else {
        // Provide a more specific error message based on the file upload error
        echo "Error in file upload: ";
        echo "New Pricing File - " . $_FILES['newPricingFile']['error'] . "; ";
        echo "Old Pricing File - " . $_FILES['oldPricingFile']['error'];
    }
}

