<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CovidController extends Controller
{
    public function getTurkey()
    {
        $response = Http::get("https://api.covidtracking.com/v1/us/daily.json");

        return ["result" => $response->json()];
    }

    public function getFinance()
    {
        $response = Http::withHeaders([
            'x-rapidapi-key' => '',
            'x-rapidapi-host' => 'apidojo-yahoo-finance-v1.p.rapidapi.com'
        ])->get('https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v3/get-historical-data?symbol=AMRN&region=US');

        return ["result" => $response->json()];
    }
}
