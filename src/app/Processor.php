<?php

namespace App;

class Processor
{
    public function processFiles(string $newPricingFile, string $oldPricingFile, string $suffix): void
    {
        $newPricingData = $this->readCSV($newPricingFile);
        $oldPricingData = $this->readCSV($oldPricingFile);

        $updatedData = $this->updatePricingData($newPricingData, $oldPricingData, $suffix);

        $this->writeCSV($updatedData);
    }

    private function readCSV(string $file): array
    {
        $data = [];

        return $data;
    }

    private function updatePricingData(array $newPricingData, array $oldPricingData, string $suffix): array
    {
        // Process the data and return the updated data
    }

    private function writeCSV($data): void
    {
        // Write the processed data to a new CSV file
    }
}
