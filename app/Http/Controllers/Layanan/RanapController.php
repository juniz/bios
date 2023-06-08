<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Traits\Token;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class RanapController extends Controller
{
    use Token, RequestAPI, RequestDB;
    public $header, $token, $url, $data, $headTable, $tanggal, $keterangan;

    public function __construct(Request $request)
    {
        $this->token = Cache::get('token') ?? $this->getToken()->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->url = 'kesehatan/layanan/pasien_ranap';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Kode Kelas', 'Jumlah', 'Status', 'Send at', 'Updated at', 'Aksi'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.ranap',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'ranap' => $this->counRanap($this->tanggal),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $response = [];
        if(is_array($input['kode_kelas'])){
            for($i=0; $i < count($input['kode_kelas']); $i++){
                $layanan = $input['kode_kelas'][$i];
                $jumlah =  $input['jumlah'][$i];
                $body = [
                    'tgl_transaksi' => $input['tgl_transaksi'],
                    'kode_kelas' => $layanan,
                    'jumlah' => $jumlah,
                ];
                $response = $this->postData($this->url, $this->header, $body, 'bios_log_ranap');
                if($response->json()['status'] != 'MSG20003'){
                    return $response->json();
                }
            }
        }else{
            $response = $this->postData($this->url, $this->header, $input, 'bios_log_ranap');
        }
        
        return $response->json();
    }

    public function read()
    {
        return $this->bacaLog('bios_log_ranap');
    }
    
}
