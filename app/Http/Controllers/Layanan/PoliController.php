<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PoliController extends Controller
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
        $this->url = 'kesehatan/layanan/pasien_ralan_poli';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Nama Poli', 'Jumlah'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
    }

    public function index()
    {
        return view('layanan.poli',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'poli' => $this->countPoli(),
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = [];
        for($i=0; $i < count($input['nama_poli']); $i++){
            $layanan = $input['nama_poli'][$i];
            $jumlah =  $input['jumlah'][$i];
            $body = [
                'tgl_transaksi' => $input['tgl_transaksi'],
                'nama_poli' => $layanan,
                'jumlah' => $jumlah,
            ];
            $response = $this->postData($this->url, $this->header, $body);
            if($response->json()['status'] != 'MSG20003'){
                return $response->json();
            }
        }
        
        return $response->json();
    }

    public function read()
    {
        $response = $this->getData($this->url, $this->header);
        return $response->json();
    }

    public function countPoli()
    {
        $data = DB::table('reg_periksa')
                    ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                    ->where('tgl_registrasi', $this->tanggal)
                    ->where('stts', 'Sudah')
                    ->where('poliklinik.nm_poli', 'like', 'KLINIK%')
                    ->groupBy('poliklinik.nm_poli')
                    ->selectRaw("poliklinik.nm_poli, count(reg_periksa.no_rawat) as jml")
                    ->get();
        return $data;
    }
}
