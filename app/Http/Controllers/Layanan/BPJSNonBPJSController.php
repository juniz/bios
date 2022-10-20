<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Token;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BPJSNonBPJSController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $tanggal, $keterangan;

    public function __construct(Request $request)
    {
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->url = 'kesehatan/layanan/bpjs_nonbpbjs';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Jumlah BPJS', 'Jumlah Non BPJS'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.bpjs-nonbpjs',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'jumlah_BPJS' => $this->countBPJS($this->tanggal),
            'jumlah_Non_BPJS' => $this->countNonBPJS($this->tanggal),
            'keterangan' => $this->keterangan,
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

    // public function countBPJS()
    // {
    //    $data = DB::table('reg_periksa')
    //                 ->where('tgl_registrasi', $this->tanggal)
    //                 ->where('stts', '<>', 'Batal')
    //                 ->where(function($query){
    //                     $query->orWhere('kd_pj', 'BPJ')
    //                          ->orWhere('kd_pj', 'BTK');
    //                 })
    //                 ->where('kd_pj', 'BPJ')
    //                 ->count();
    //     return $data;
    // }

    // public function countNonBPJS()
    // {
    //    $data = DB::table('reg_periksa')
    //                 ->where('tgl_registrasi', $this->tanggal)
    //                 ->where('stts', '<>', 'Batal')
    //                 ->where(function($query){
    //                     $query->orWhere('kd_pj', '<>', 'BPJ')
    //                          ->orWhere('kd_pj', '<>', 'BTK');
    //                 })
    //                 ->count();
    //     return $data;
    // }
}
