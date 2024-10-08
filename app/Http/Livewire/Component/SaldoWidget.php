<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Kelolaan;

class SaldoWidget extends Component
{
    public $loadOperasional = false, $loadKelolaan = false, $loadKas = false;

    public function render()
    {
        return view('livewire.component.saldo-widget', [
            'kelolaan' => $this->loadKelolaan ? $this->getKelolaan() : 0,
            'kas' => $this->loadKas ? $this->getKas() : 0,
        ]);
    }

    public function readyLoadOperasional()
    {
        $this->loadOperasional = true;
    }

    public function readyLoadKelolaan()
    {
        $this->loadKelolaan = true;
    }

    public function getOperasional()
    {
        $rek = DB::table('bios_operasional')->groupBy('no_rekening')->get();
        foreach($rek as $r){
            $data[$r->no_rekening] = DB::table('bios_operasional')
                                        ->where('no_rekening', $r->no_rekening)
                                        ->orderByDesc('tgl_transaksi')
                                        ->first();
        }
        // $data = DB::table('bios_log_operasional')->orderByDesc('tgl_transaksi')->first();
        // return $data->saldo_akhir;
        // dd($data);
        return $data;
    }

    public function getKelolaan()
    {
        $data = Kelolaan::orderByDesc('tgl_transaksi')->first();
        return $data->saldo_akhir;
    }

    public function getKas()
    {
        return DB::table('bios_log_kas')->orderByDesc('tgl_transaksi')->first();
    }
}
