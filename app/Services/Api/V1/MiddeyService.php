<?php

namespace App\Services\Api\V1;

use Illuminate\Support\Facades\Http;

class MiddeyService
{
    public function middey ($url, $data)
    {
        $response = Http::withHeaders([
            // "Authorization"=> 'Bearer '.env('MIDDEY_SERVICE_SECRET_KEY'),
            "Cache-Control" => 'no-cache',
        ])->post(env('MIDDEY_SERVICE_URL').$url, $data);
        // $res = json_decode($response->getBody());  
        return $response->getBody();
    }
}

