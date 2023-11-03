<?php

namespace App\Http\Livewire\Component;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SaldoWidget extends Component
{
    public $loadOperasional = false, $loadKelolaan = false, $loadKas = false;

    public function render()
    {
        return view('livewire.component.saldo-widget', [
            'operasional' => $this->loadOperasional ? $this->getOperasional() : 0,
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
        $data = DB::table('bios_log_operasional')->orderByDesc('tgl_transaksi')->first();
        return $data->saldo_akhir;
    }

    public function getKelolaan()
    {
        $data = DB::table('bios_log_kelolaan')->orderByDesc('tgl_transaksi')->first();
        return $data->saldo_akhir;
    }

    public function getKas()
    {
        return DB::table('bios_log_kas')->orderByDesc('tgl_transaksi')->first();
    }
}
