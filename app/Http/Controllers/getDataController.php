<?php

namespace App\Http\Controllers;

use App\ApiService;

class getDataController extends Controller
{
    private $apiService;

    public function index(ApiService $apiService)
    {
        $this->apiService = $apiService;
        $data = $this->apiService->getDataFromApi()->json();

        return view('home', ['data' => $data]);
    }
}
