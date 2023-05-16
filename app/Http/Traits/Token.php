<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

trait Token {
    use Telegram;
    public function getToken() {
        $i = 0;
        try{
            $response = Http::post(config('URL_TOKEN', 'https://training-bios2.kemenkeu.go.id/api/token'),[
                'satker' => config('SATKER', '679614'),
                'key' => config('KEY', 'HE7FjyqfTfmh5N6ozvniuHxT9Ho530Rv')
            ]);
            if($response->json()['status'] != 'MSG20004'){
                $this->sendMessage('Token Error : '.$response->getBody());
                if($i<3){
                    $i++;
                    $this->getToken();
                }
                
            }
            Cache::put('token', $response->json()['token'] ?? null, now()->addMinutes(1440));
            return $response;
        
        }catch(\Exception $e){
            $response = $this->errorToken($e->getMessage());
            $this->sendMessage($e->getMessage() ?? 'Error Token');
            return $response;
        }
        
        // return $response;
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