<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use GuzzleHttp\Exception\BadResponseException;

trait RequestAPI {
    use Telegram;
    protected $urlPost ='https://training-bios2.kemenkeu.go.id/api/ws/';
    protected $urlGet = 'https://training-bios2.kemenkeu.go.id/api/get/data/';
    public function postData($url, $header, $body)
    {
        try{
            $response = Http::asForm()->withHeaders($header)->retry(5, 1000000)->post(env('URL_POST_DATA' ,$this->urlPost). $url, $body);
            if($response->json()['status'] != 'MSG20003'){
                $this->sendMessage($url.' : '.$response->getBody());
            }
            
        }catch(BadResponseException $e){
            $this->sendMessage($e->getResponse()->getBody()->getContents());
            return $e->getResponse();
        }
        return $response;
    }

    public function getData($url, $header)
    {
        try{
            $response = Http::withHeaders($header)->retry(5, 100)->post(env('URL_GET_DATA', $this->urlGet). $url);
            if($response->json()['status'] != 'MSG20001'){
                $this->sendMessage($url.' : '.$response->getBody());
            }
            
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