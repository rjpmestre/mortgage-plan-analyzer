<?php

namespace App\Custom;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

/**
 * Saving current euribor 12m index in a file.
 * Updating on access once a day should be ok.
 * TODO: move to cron job.
 */
class EuriborAcquisitor
{
    public static $API_ADDRESS = 'https://euribor.p.rapidapi.com/12m/';
    public static $EURIBOR_VALUE_JSON_KEY = 'Euribor value';
    public static $EURIBOR_FILE_PATH = 'euribor';

    public function getEuribor12M()
    {

        if (!$this->isFileRecent()) {
            $updatedEuribor = $this->getEuriborFromApi();
            if(!empty($updatedEuribor)){
                Storage::put(EuriborAcquisitor::$EURIBOR_FILE_PATH, $updatedEuribor);
            }
        }

        return
            Storage::exists(EuriborAcquisitor::$EURIBOR_FILE_PATH) ?
            Storage::get(EuriborAcquisitor::$EURIBOR_FILE_PATH) : 0;
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
     * Returns the euribor value from the API or null if something went wrong.
     */
    private function getEuriborFromApi(){
        $apiResponse = Http::withoutVerifying()
        ->withHeaders([
            'X-RapidAPI-Host' => 'euribor.p.rapidapi.com',
            'X-RapidAPI-Key' => env('RAPID_API_KEY_EURIBOR'),
        ])
        ->get($this::$API_ADDRESS);

        if ($apiResponse->successful()) {
            if(!isset($apiResponse[EuriborAcquisitor::$EURIBOR_VALUE_JSON_KEY])){
                Log::alert("Missing value in the Euribor API respons. ". json_encode($apiResponse->json()));
                return null;
            }
            return $apiResponse[EuriborAcquisitor::$EURIBOR_VALUE_JSON_KEY];
        } else {
            Log::alert("Something went wrong with the Euribor API request");
            return null;
        }
    }
}
