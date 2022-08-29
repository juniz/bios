<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait Token {
    public function getToken() {
        $response = Http::post(env('URL_TOKEN'),[
            'satker' => env('SATKER'),
            'key' => env('KEY')
        ]);
        return $response;
    }
}