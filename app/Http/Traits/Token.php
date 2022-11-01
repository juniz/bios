<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

trait Token {
    public function getToken() {
        $response = Http::retry(5, 1000000)->post(config('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'),[
            'satker' => config('SATKER', '679614'),
            'key' => config('KEY', 'HE7FjyqfTfmh5N6ozvniuHxT9Ho530Rv')
        ]);
        // Cache::put('token', $response->json()['token'], 60);
        if($response->successful()) {
            return $response;
        } else {
            $this->info('Token gagal didapatkan error '.$response->status().' :'. $response->throw());
            $this->getToken();
        }
        return $response;
    }
}