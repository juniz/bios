<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\Http;

trait RequestAPI {
    protected $urlPost ='https://training-bios2.kemenkeu.go.id/api/ws/';
    protected $urlGet = 'https://training-bios2.kemenkeu.go.id/api/get/data/';
    public function postData($url, $header, $body)
    {
        $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA' ,$this->urlPost). $url, $body);
        return $response;
    }

    public function getData($url, $header)
    {
        $response = Http::withHeaders($header)->post(env('URL_GET_DATA', $this->urlGet). $url);
        return $response;
    }

    public function getBank()
    {
        $response = Http::get(env('URL_POST_DATA', $this->urlGet).'ref/bank');
        return $response;
    }

    public function getAkun()
    {
        $response = Http::get(env('URL_POST_DATA', $this->urlGet).'ref/akun');
        return $response;
    }
}