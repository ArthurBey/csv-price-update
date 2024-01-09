<?php

namespace App;

class Processor
{
    public function processFiles($newPricingFile, $oldPricingFile, $suffix)
    {
        $newPricingData = $this->readCSV($newPricingFile);
        $oldPricingData = $this->readCSV($oldPricingFile);

        $updatedData = $this->updatePricingData($newPricingData, $oldPricingData, $suffix);

        $this->writeCSV($updatedData);
    }

    private function readCSV($file)
    {
        // Read the CSV file and return its contents
    }

    private function updatePricingData($newPricingData, $oldPricingData, $suffix)
    {
        // Process the data and return the updated data
    }

    private function writeCSV($data)
    {
        // Write the processed data to a new CSV file
    }
}
