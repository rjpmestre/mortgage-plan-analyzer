<?php

namespace App\Custom;
use finfo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Nette\Utils\Json;
use App\Enums\EuriborMaturity;
/**
 * Saving current euribor 12m index in a file.
 * Updating on access once a day should be ok.
 * TODO: move to cron job.
 */
class EuriborAcquisitor
{
    public static $API_ADDRESS = 'https://euribor.p.rapidapi.com/';
    public static $EURIBOR_FILE_PATH = 'euribor_values';


    public function getEuriborAtMaturity(EuriborMaturity $maturity = EuriborMaturity::EURIBOR_12M)
    {
        $euriborValues = $this->getEuriborValues();
        if(!isset($euriborValues[$maturity->value])){
            Log::alert("Could not retrieve Euribor values for maturity: " . $maturity->value);
            return 0.0;
        }
        return $euriborValues[$maturity->value];
    }

    /**
     * Returns the euribor json values, updating the file if needed.
     */
    public function getEuriborValues()
    {
        if (!$this->isFileRecent()) {
            $updatedEuribor = $this->getEuriborValuesFromApi();
            if(!empty($updatedEuribor)){
                Storage::put(EuriborAcquisitor::$EURIBOR_FILE_PATH, Json::encode($updatedEuribor));
            }
        }

        if (Storage::exists(EuriborAcquisitor::$EURIBOR_FILE_PATH)) {
            return Json::decode(Storage::get(EuriborAcquisitor::$EURIBOR_FILE_PATH), Json::FORCE_ARRAY);
        }

        return [];
    }

    /**
     * Returns false is the file was not updated in the last 24hours or does not exist.
     */
    private function isFileRecent()
    {
        if (!Storage::exists(EuriborAcquisitor::$EURIBOR_FILE_PATH)) {
            return false;
        }

        return now()->subHours(24)->timestamp <= Storage::lastModified(EuriborAcquisitor::$EURIBOR_FILE_PATH);
    }

    /**
     * Returns the euribor json from the API or null if something went wrong.
     */
    private function getEuriborValuesFromApi(){
        log::info("Requesting Euribor values from API...");
        $apiResponse = Http::withoutVerifying()
        ->withHeaders([
            'X-RapidAPI-Host' => 'euribor.p.rapidapi.com',
            'X-RapidAPI-Key' => env('RAPID_API_KEY_EURIBOR'),
        ])
        ->get($this::$API_ADDRESS);

        if ($apiResponse->successful()) {
            return $apiResponse->json();
        } else {
            Log::alert("Something went wrong with the Euribor API request" . env('RAPID_API_KEY_EURIBOR'));
            return null;
        }
    }
}
