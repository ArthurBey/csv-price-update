<?php

namespace App;

class Processor
{
    public function processFiles(string $newPricingFile, string $oldPricingFile, string $suffix): void
    {
        $newPricingData = $this->readCSV($newPricingFile);
        $oldPricingData = $this->readCSV($oldPricingFile);

        // Debugging: Check if data is read correctly
        error_log("New Pricing Data: " . print_r($newPricingData, true));
        error_log("Old Pricing Data: " . print_r($oldPricingData, true));

        $updatedData = $this->updatePricingData($newPricingData, $oldPricingData, $suffix);

        // Debugging: Check if data is updated
        error_log("Updated Data: " . print_r($updatedData, true));

        $this->writeCSV($updatedData);
    }

    private function readCSV(string $filePath): array
    {
        $data = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }
        return $data;
    }

    private function updatePricingData(array $newPricingData, array $oldPricingData, string $suffix): array
    {
        var_dump($newPricingData);
        echo "STOP LA";
        exit();
        $specialPrefixes = ['CSD-CA-', 'WP-3D-AS-', 'WP-4D-AS-', 'WP-6D-AS-']; // Special prefixes
        $updatedData = $oldPricingData;

        foreach ($newPricingData as $newData) {
            $itemcodePrefix = $newData[0]; // Assuming 'itemcode prefix' is at index 0
            $priceTypeID = $newData[1]; // Assuming 'PriceTypeID' is at index 1

            // Replace suffix for special prefixes
            $actualSuffix = in_array($itemcodePrefix, $specialPrefixes) && $suffix === 'FR' ? 'EU' : $suffix;
            $fullItemCode = $itemcodePrefix . $actualSuffix;

            foreach ($oldPricingData as $key => $oldData) {
                if ($oldData[0] === $fullItemCode && $oldData[2] == $priceTypeID) { // Assuming 'itemcode' and 'PriceTypeID' at indices 0 and 2 in old data
                    // Update data (indices are assumed, you need to replace them with actual indices)
                    $updatedData[$key][3] = $newData['VatInc']; // 'VatInc' value from new data
                    $updatedData[$key][4] = $newData['LocalCV']; // 'LocalCV'
                    $updatedData[$key][5] = $newData['QV']; // 'QV'
                    $updatedData[$key][6] = $newData['RetailProfit_USD']; // 'RetailProfit_USD'
                    // Continue updating other relevant fields
                }
            }
        }

        return $updatedData;
    }

    private function writeCSV(array $data, string $outputFilePath): void
    {
        if (($handle = fopen($outputFilePath, 'w')) !== false) {
            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        }
    }
}
