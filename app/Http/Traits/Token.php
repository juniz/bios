<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Facades\Log;

trait Token {
    use Telegram;
    public function getToken() {
        try{
            $response = Http::retry(5, 1000000)->post(config('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'),[
                'satker' => config('SATKER', '679614'),
                'key' => config('KEY', 'HE7FjyqfTfmh5N6ozvniuHxT9Ho530Rv')
            ]);
        }catch(BadResponseException $e){
            $this->sendMessage($e->getResponse()->getBody()->getContents());
            Log::error(config('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'), $e->getResponse());
            return $e->getResponse();
        }
        
        return $response;
    }
}