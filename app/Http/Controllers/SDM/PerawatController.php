<?php

namespace App\Http\Controllers\SDM;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class PerawatController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $bidang, $tanggal, $keterangan;

    public function __construct()
    {
        $this->token = Cache::get('token');
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->bidang = 'PERAWAT';
        $this->url = 'kesehatan/sdm/perawat';
        $this->data = $this->read();
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->headTable = ['Tgl Transaksi', 'Tgl Update', 'PNS', 'PPPK', 'Non PNS Tetap', 'Kontrak', 'Anggota'];
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data pada saat tanggal berkenaan, bersifat akumulatif.',
            'Data yang dikirimkan merupakan jumlah pegawai sesuai kriteria.',
            'Data awal dikirimkan pada awal tahun berkenaan, updating data dikirimkan per periode semesteran/tahunan.'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sdm.perawat',[
            'data' => $this->data, 
            'tanggal' => $this->tanggal,
            'head' => $this->headTable, 
            'anggota' => $this->anggota($this->bidang),
            'pns' => $this->pns($this->bidang),
            'p3k' => $this->p3k($this->bidang),
            'non_pns' => $this->nonPNS($this->bidang),
            'kontrak' => $this->kontrak($this->bidang),
            'keterangan' => $this->keterangan,
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
