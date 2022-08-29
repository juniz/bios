<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait RequestAPI {

    public function postData($url, $header, $body)
    {
        $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA'). $url, $body);
        return $response;
    }

    public function getData($url, $header)
    {
        $response = Http::withHeaders($header)->post(env('URL_GET_DATA'). $url);
        return $response;
    }
}