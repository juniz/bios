<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;
use App\Http\Traits\Telegram;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Traits\Token;

trait RequestAPI
{
    use Telegram, RequestDB, Token;
    protected $urlPost = 'https://bios.kemenkeu.go.id/api/ws/';
    protected $urlGet = 'https://bios.kemenkeu.go.id/api/get/data/';

    public function postData($url, $header, $body, $table, $delay = 0)
    {
        try {
            sleep($delay);
            $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA', $this->urlPost) . $url, $body);
            $data = $response->json();
            $payloads = array_merge($body, [
                'uuid'  =>  Str::uuid(),
                'response'  =>  $data['status'],
                'send_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            if(Arr::has($payloads, 'pns')){
                $this->simpanLogSDM($table, $payloads);
            }else{
                $this->simpanLog($table, $payloads);
            }
            if ($response->json()['status'] == 'MSG20003') {
                // $this->sendMessage($url.' : '.$response->getBody());
                // Log::info($this->urlPost.$url, $response->json());
            } else {
                $this->sendMessage($url . ' : ' . $response->getBody());
                // Log::warning($this->urlPost.$url, $response->json());
            }
        } catch (\Exception $e) {
            $this->sendMessage($e->getMessage() ?? 'Terjadi kesalahan saat akses server bios');
            // Log::error($this->urlPost.$url, $e->getResponse());
            return $e->getMessage() ?? 'Terjadi kesalahan saat akses server bios';
        }
        return $response;
    }

    public function postDataSDM($url, $header, $body, $table, $delay = 0)
    {
        try {
            sleep($delay);
            $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA', $this->urlPost) . $url, $body);
            $data = $response->json();
            $payloads = array_merge($body, [
                'uuid'  =>  Str::uuid(),
                'response'  =>  $data['status'],
                'send_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            $this->simpanLogSDM($table, $payloads);
            if ($response->json()['status'] == 'MSG20003') {
                // $this->sendMessage($url.' : '.$response->getBody());
                // Log::info($this->urlPost.$url, $response->json());
            } else {
                $this->sendMessage($url . ' : ' . $response->getBody());
                // Log::warning($this->urlPost.$url, $response->json());
            }
        } catch (\Exception $e) {
            $this->sendMessage($e->getMessage() ?? 'Terjadi kesalahan saat akses server bios');
            // Log::error($this->urlPost.$url, $e->getResponse());
            return $e->getMessage() ?? 'Terjadi kesalahan saat akses server bios';
        }
        return $response;
    }

    public function getData($url, $header)
    {
        try {
            $response = Http::withHeaders($header)->retry(5, 100)->post(env('URL_GET_DATA', $this->urlGet) . $url);
            // if($response->json()['status'] != 'MSG20001'){
            //     $this->sendMessage($url.' : '.$response->getBody());
            // }

        } catch (BadResponseException $e) {
            $this->sendMessage($e->getResponse()->getBody()->getContents());
            return $e->getResponse();
        }

        return $response;
    }

    public function getBank()
    {
        $response = Http::retry(5, 100)->get(env('URL_POST_DATA', $this->urlGet) . 'ref/bank');
        return $response;
    }

    public function getAkun()
    {
        $response = Http::retry(5, 100)->get(env('URL_POST_DATA', $this->urlGet) . 'ref/akun');
        return $response;
    }

    public function responseStatus($status)
    {
        $response = "";
        switch($status){
            case "MSG20001":
                $response = "Data ditemukan";
                break;
            case "MSG20002":
                $response = "Data tidak ditemukan";
                break;
            case "MSG20003":
                $response = "Data berhasil disimpan";
                break;
            case "MSG20004":
                $response = "Request token berhasil";
                break;
            case "MSG20005":
                $response = "Parameter tidak valid";
                break;
            case "MSG40101":
                $response = "Otentikasi gagal, kode satker salah";
                break;
            case "MSG40102":
                $response = "Otentikasi gagal, key salah";
                break;
            case "MSG40103":
                $response = "Token invalid atau sudah tidak berlaku";
                break;
            case "MSG40401":
                $response = "Resource tidak ditemukan";
                break;
            case "MSG50001":
                $response = "Controller error, silahkan hubungi administrator";
                break;
            default:
                $response = "Terjadi kesalahan saat akses server bios";
                break;
        }
        return $response;
    }

    public function responseFailed($message)
    {
        $response = [
            'status' => 'MSG50000',
            'message' => $message
        ];
        return $response;
    }

    public function sendData($url, $body)
    {
        $token = Cache::get('token') ?? $this->getToken()->json()['token'];
        $header = [
            'token' => $token ?? '-',
            'Content-Type' => 'multipart/form-data'
        ];
        $response = Http::asForm()->withHeaders($header)->post(env('URL_POST_DATA', $this->urlPost) . $url, $body);
        return $response;
    }
}
