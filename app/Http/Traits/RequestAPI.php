<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

trait RequestAPI {
    use Telegram, RequestDB;
    protected $urlPost ='https://training-bios2.kemenkeu.go.id/api/ws/';
    protected $urlGet = 'https://training-bios2.kemenkeu.go.id/api/get/data/';
    public function postData($url, $header, $body, $delay = 0)
    {
        try{
            sleep($delay);
            $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA' ,$this->urlPost). $url, $body);
            $data = $response->json();
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            // $this->insertLog($this->urlPost.$url, $response->body(), 'warning', $data['message'], 'none', $now);
            if($response->json()['status'] == 'MSG20003'){
                // $this->sendMessage($url.' : '.$response->getBody());
                Log::info($this->urlPost.$url, $response->json());
            }else{
                $this->sendMessage($url.' : '.$response->getBody());
                Log::warning($this->urlPost.$url, $response->json());
            }
            
        }catch(BadResponseException $e){
            $this->sendMessage($e->getResponse()->getBody()->getContents());
            Log::error($this->urlPost.$url, $e->getResponse());
            return $e->getResponse();
        }
        return $response;
    }

    public function getData($url, $header)
    {
        try{
            $response = Http::withHeaders($header)->retry(5, 100)->post(env('URL_GET_DATA', $this->urlGet). $url);
            // if($response->json()['status'] != 'MSG20001'){
            //     $this->sendMessage($url.' : '.$response->getBody());
            // }
            
        }catch(BadResponseException $e){
            $this->sendMessage($e->getResponse()->getBody()->getContents());
            return $e->getResponse();
        }
        
        return $response;
    }

    public function getBank()
    {
        $response = Http::retry(5, 100)->get(env('URL_POST_DATA', $this->urlGet).'ref/bank');
        return $response;
    }

    public function getAkun()
    {
        $response = Http::retry(5, 100)->get(env('URL_POST_DATA', $this->urlGet).'ref/akun');
        return $response;
    }
}