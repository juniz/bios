<?php

namespace App\Console\Commands;
use App\Http\Controllers\Layanan\RalanController;
use Illuminate\Console\Command;
use App\Http\Traits\Token;
use App\Http\Traits\RequestDB;
use Illuminate\Support\Carbon;
use App\Http\Traits\RequestAPI;

class LabParamCron extends Command
{
    use Token, RequestAPI, RequestDB;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:labparam {lab} {jml}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job Lab BIOS';
    public $token, $header, $tanggal;

    public function __construct()
   {
        parent::__construct();
        $token = $this->getToken();
        $this->token = $token->json()['token'];
        $this->header = [
            'token' => $this->token,
            'Content-Type' => 'multipart/form-data'
        ]; 
        $this->tanggal = Carbon::now()->subDay()->isoFormat('YYYY-MM-DD');
   }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->postLayananLabParameter();
        // $this->postLayananLabSample();
    }

    // public function postLayananLabParameter()
    // {
    //     $url = 'kesehatan/layanan/laboratorium_detail';
    //     $bidang = 'LABORATORIUM PARAMETER';
    //     $lab = $this->countLab($this->tanggal);
    //     foreach($lab as $l){
    //         $input = array(
    //             'tgl_transaksi' => $this->tanggal,
    //             'nama_layanan' => $l->nm_perawatan,
    //             'jumlah' => $l->jml,
    //         );
    //         $response = $this->postData($url, $this->header, $input);
    //         $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
    //         $this->info($now.'|'.$this->description.'|'.$bidang.'|'.$l->nm_perawatan.'|'.$response->body());
    //     }
    // }

    public function postLayananLabParameter()
    {
        $url = 'kesehatan/layanan/laboratorium_detail';
        $bidang = 'LABORATORIUM PARAMETER';
        $lab = $this->nmPerawatanLab($this->argument('lab'));
        // $lab = $this->argument('lab');
        $jml = $this->argument('jml');
        $input = array(
                'tgl_transaksi' => $this->tanggal,
                'nama_layanan' => $lab,
                'jumlah' => $jml,
            );
            $response = $this->postData($url, $this->header, $input);
            $now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
            $this->info($now.'|'.$this->description.'|'.$bidang.'|'.$lab.'|'.$response->body());
        
    }

    // public function postLayananLabSample()
    // {
    //     $url = 'kesehatan/layanan/laboratorium';
    //     $bidang = 'LABORATORIUM SAMPLE';
    //     $input = array(
    //         'tgl_transaksi' => $this->tanggal,
    //         'jumlah' =>  $this->getLab($this->tanggal),
    //     );
    //     $response = $this->postData($url, $this->header, $input);
    //     $now = Carbon::now()->isoFormat('DD-MM-YYYY HH:mm:ss');
    //     $this->info($now.'|'.$this->description.'|'.$bidang.'|'.$response->body());
    // }
 
}
