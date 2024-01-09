<?php

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$outputFile = $root . 'output' . DIRECTORY_SEPARATOR . 'updated_pricing.csv';
require $root . 'vendor/autoload.php';

include_once $root . 'view/uploadForm.php';

use App\Processor;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $newPricingFile = $_FILES['newPricingFile']['tmp_name'];
    $oldPricingFile = $_FILES['oldPricingFile']['tmp_name'];
    $suffix = $_POST['suffix'];

    $processor = new Processor();
    $processor->processFiles($newPricingFile, $oldPricingFile, $suffix, $outputFile);

    // Add error handling and user feedback
    echo "Processing completed. Check the output file.";
}