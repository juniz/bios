<?php

namespace App\Http\Controllers\IKT;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Facades\Cache;

class Visite3Controller extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable;

    public function __construct()
    {
        $this->token = Cache::get('token');
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->url = 'kesehatan/ikt/visite_3';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah'];
    }

    public function index()
    {
        return view('ikt.visite3',[
            'data' => $this->data, 
            'head' => $this->headTable, 
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = $this->postData($this->url, $this->header, $input);
        return $response->json();
    }

    public function read()
    {
        $response = $this->getData($this->url, $this->header);
        return $response->json();
    }
}
