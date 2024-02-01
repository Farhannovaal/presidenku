<?php

namespace App;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private $apiUrl = 'https://mocki.io/v1/92a1f2ef-bef2-4f84-8f06-1965f0fca1a7';

    public function getDataFromApi()
    {
        return Http::get($this->apiUrl);
    }
}
