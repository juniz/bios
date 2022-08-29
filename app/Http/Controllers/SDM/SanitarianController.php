<?php

namespace App\Http\Controllers\SDM;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use App\Http\Traits\RequestAPI;

class SanitarianController extends Controller
{
    use Token, RequestAPI;
    public $header, $token, $url, $data, $headTable;

    public function __construct()
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $token->json()['token'],
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->url = 'kesehatan/sdm/sanitarian';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Tgl Update', 'PNS', 'PPPK', 'Non PNS Tetap', 'Kontrak', 'Anggota'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sdm.radiographer',['data' => $this->data, 'head' => $this->headTable]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        // $response = Http::asForm()->withHeaders($this->header)->post(env('URL_POST_DATA'). $this->url, $input);
        $response = $this->postData($this->url, $this->header, $input);
        return $response->json();
    }

    public function read()
    {
        $response = $this->getData($this->url, $this->header);
        return $response->json();
    }
}
