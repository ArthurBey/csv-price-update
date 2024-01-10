<?php

namespace App;

class Processor
{
    public function processFiles(string $newPricingFile, string $oldPricingFile, string $suffix, string $outputFilePath): void
    {
        $newPricingData = $this->readCSV($newPricingFile);
        $oldPricingData = $this->readCSV($oldPricingFile);

        // Debugging: Check if data is read correctly
        error_log("New Pricing Data: " . print_r($newPricingData, true));
        error_log("Old Pricing Data: " . print_r($oldPricingData, true));

        $updatedData = $this->updatePricingData($newPricingData, $oldPricingData, $suffix);

        // Debugging: Check if data is updated
        error_log("Updated Data: " . print_r($updatedData, true));

        $this->writeCSV($updatedData, $outputFilePath);
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
//        echo '<pre>';
//        print_r($oldPricingData);
//        echo '</pre>';
//        exit();

        $specialPrefixes = ['CSD-CA-', 'WP-3D-AS-', 'WP-4D-AS-', 'WP-6D-AS-', 'SE-03-', 'PF-03-', 'CY-03-', 'CJ-03-', 'TS-03-', 'NC-03-', 'CC-03-', 'SE-05-', 'PF-05-', 'CY-05-', 'CJ-05-', 'TS-05-', 'NC-05-', 'CC-05-'];

        $updatedData = $oldPricingData; // Initialize updatedData with oldPricingData

        for ($i = 1; $i < count($newPricingData[0]); $i++) {
            $itemcodePrefix = $newPricingData[0][$i];
            $priceTypeID = $newPricingData[1][$i];
            $vatInc = $newPricingData[2][$i];
            $localCV = $newPricingData[3][$i];
            $qv = $newPricingData[4][$i];
            $retailProfitUSD = $newPricingData[5][$i];

            $actualSuffix = in_array($itemcodePrefix, $specialPrefixes) && $suffix === 'FR' ? 'EU' : $suffix;
            $fullItemCode = $itemcodePrefix . $actualSuffix;

            foreach ($updatedData as $key => $oldData) {
                if ($key > 0 && $oldData[2] === $fullItemCode && $oldData[4] == $priceTypeID) {
                    // Update necessary fields in updatedData
                    $updatedData[$key][15] = $vatInc;
                    $updatedData[$key][16] = $localCV;
                    $updatedData[$key][17] = $qv;
                    $updatedData[$key][8] = $retailProfitUSD;
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
