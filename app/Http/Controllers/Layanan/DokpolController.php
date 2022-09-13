<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;

class DokpolController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $tanggal;

    public function __construct(Request $request)
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ];
        $this->url = 'kesehatan/layanan/dokpol';
        $this->data = $this->read();
        $this->headTable = [
            'Tgl Transaksi', 'Kedokteran Forensik', 'Psikiatri Forensik', 'Sentra Visum dan Medikolegal', 
            'PPAT', 'Odontologi Forensik', 'Psikologi Forensik', 'Antropologi Forensik', 'Olah TKP Medis',
            'Kesehatan Tahanan', 'Narkoba', 'Toksikologi Medik', 'Pelayanan DNA', 'PAM Keslap Food Security', 'DVI',
        ];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
    }

    public function index()
    {
        return view('layanan.dokpol',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
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
