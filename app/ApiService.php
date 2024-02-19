<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    private $apiUrl = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';

    public function getDataFromApi()
    {
        $response = Http::get($this->apiUrl);

        if ($response->successful()) {
            return $response->json();
        } else {
            Log::warning('Failed to fetch data from the API. HTTP status code: '.$response->status());
            return null;
        }
    }
}
