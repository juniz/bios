<?php

namespace App\Http\Controllers\SDM;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use App\Http\Traits\RequestAPI;

class LaboratoriumController extends Controller
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
        $this->url = 'kesehatan/sdm/pranata_laboratorium';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Tgl Update', 'PNS', 'PPPK', 'Non PNS Tetap', 'Kontrak', 'Anggota'];
    }

    public function index()
    {
        return view('sdm.laboratorium',['data' => $this->data, 'head' => $this->headTable]);
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