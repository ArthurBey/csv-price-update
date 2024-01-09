<?php

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
require $root . 'vendor/autoload.php';

include_once $root . 'view/uploadForm.php';

use App\Processor;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $processor = new Processor();
    $processor->processFiles($_FILES['newPricingFile'], $_FILES['oldPricingFile'], $_POST['suffix']);

    // Add error handling and user feedback
}