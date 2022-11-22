<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

trait Token {
    use Telegram;
    public function getToken() {
        try{
            $response = Http::post(config('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'),[
                'satker' => config('SATKER', '679614'),
                'key' => config('KEY', 'HE7FjyqfTfmh5N6ozvniuHxT9Ho530Rv')
            ]);
            if($response->json()['status'] != 'MSG20004'){
                $this->sendMessage('Token Error : '.$response->getBody());
                Log::warning($response->getBody());
                // return response()->json(array(
                //     "status" => $response->json()['status'],
                //     "message" => $response->json()['message'],
                //     "token" => "-"
                // ));
            }
        
        }catch(ConnectionException $e){
            $this->errorToken($e->getMessage());
            return null;
        }
        
        return $response;
    }

    public function errorToken($message){
        $this->sendMessage($message);
        Log::error($message);
        $response = array(
            "status" => "error",
            "message" => $message,
            "token" => "-"
        );
        // return $response;
    }
}