<?php

namespace App\Http\Controllers\Layanan;
use App\Http\Traits\RequestAPI;
use App\Http\Traits\RequestDB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\Token;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaboratoriumParameterController extends Controller
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
        $this->url = 'kesehatan/layanan/laboratorium_detail';
        $this->data = $this->read();
        $this->headTable = ['Tgl Transaksi', 'Nama Layanan', 'Jumlah'];
        $this->tanggal = $request->input('tgl') ?? Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
        $this->keterangan = [
            'Data yang dikirimkan merupakan posisi data terakhir pada saat tanggal berkenaan, tidak akumulatif.',
            'Data dikirimkan per periode harian.',
        ];
    }

    public function index()
    {
        return view('layanan.laboratorium-parameter',[
            'data' => $this->data, 
            'head' => $this->headTable, 
            'tanggal' => $this->tanggal,
            'lab' => $this->countLab($this->tanggal),
            'keterangan' => $this->keterangan,
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = [];
        for($i=0; $i < count($input['nama_layanan']); $i++){
            $layanan = $input['nama_layanan'][$i];
            $jumlah =  $input['jumlah'][$i];
            $body = [
                'tgl_transaksi' => $input['tgl_transaksi'],
                'nama_layanan' => $layanan,
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

    // public function getLab()
    // {
    //     $data = DB::table('jns_perawatan_lab')
    //                 ->where('status', 1)
    //                 ->select('kd_jenis_prw', 'nm_perawatan')
    //                 ->get();
    //     return $data;
    // }

    // public function countLab($tanggal)
    // {
    //     $data = DB::table('periksa_lab')
    //                 ->join('jns_perawatan_lab', 'periksa_lab.kd_jenis_prw', '=', 'jns_perawatan_lab.kd_jenis_prw')
    //                 ->where('periksa_lab.tgl_periksa', $tanggal)
    //                 ->groupBy('jns_perawatan_lab.nm_perawatan')
    //                 ->selectRaw("jns_perawatan_lab.nm_perawatan, count(periksa_lab.kd_jenis_prw) as jml")
    //                 ->get();
    //     return $data;
    // }
}
