<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait Token {
    public function getToken() {
        $response = Http::post(env('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'),[
            'satker' => env('SATKER', '679614'),
            'key' => env('KEY', 'HE7FjyqfTfmh5N6ozvniuHxT9Ho530Rv')
        ]);
        return $response;
    }
}