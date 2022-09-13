<?php

namespace App\Http\Controllers\SDM;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;

class SpesialisController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $bidang, $tanggal;

    public function __construct()
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->bidang = 'DOKTER SPESIALIS';
        $this->url = 'kesehatan/sdm/dokter_spesialis';
        $this->data = $this->read();
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->headTable = ['Tgl Transaksi', 'Tgl Update', 'PNS', 'PPPK', 'Non PNS Tetap', 'Kontrak', 'Anggota'];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sdm.spesialis',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'anggota' => $this->anggota($this->bidang),
            'pns' => $this->pns($this->bidang),
            'p3k' => $this->p3k($this->bidang),
            'non_pns' => $this->nonPNS($this->bidang),
            'kontrak' => $this->kontrak($this->bidang),
            'tanggal' => $this->tanggal,
        ]);
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
