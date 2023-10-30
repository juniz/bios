<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SdmWidget extends Component
{
    public array $label = [];
    public array $dataset = [];
    public $jenis = [
        'Perawat' => 'bios_log_perawat',
        'Bidan' => 'bios_log_bidan',
        'Laboratorium' => 'bios_log_laboratorium',
        'Radiographer' => 'bios_log_radiographer',
        'Nutritionist' => 'bios_log_nutritionist',
        'Pharmacist' => 'bios_log_pharmacist',
        'Profesional Lainnya' => 'bios_log_profesional_lainnya',
        'Non Medis' => 'bios_log_non_medis',
        'Sanitarian' => 'bios_log_sanitarian',
        'Non-Medis Administrasi' => 'bios_log_administrasi',
        'Dokter Spesialis' => 'bios_log_spesialis',
        'Dokter Gigi' => 'bios_log_dokter_gigi',
        'Dokter Umum' => 'bios_log_dokter_umum',
    ];
    public $selectedJenis;

    public function render()
    {
        return view('livewire.component.sdm-widget');
    }

    public function mount()
    {
        $this->selectedJenis = 'Perawat';
        $this->label = $this->getLabel();
        $this->dataset = [
            [
                'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e74a3b'],
                'data' => [0, 0, 0, 0, 0],
            ]
        ];
        // $this->getDataset($this->jenis[$this->selectedJenis]);
    }

    public function getLabel()
    {
        return ['PNS', 'PPPK', 'Anggota', 'Non PNS Tetap', 'Kontrak'];
    }

    public function getData($database)
    {
        return DB::table($database)->orderByDesc('tgl_transaksi')->first();
    }

    public function getDataset($database)
    {
        $data = $this->getData($database);
        $this->dataset = [
            [
                'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e74a3b'],
                'data' => [$data->pns, $data->pppk, $data->anggota, $data->non_pns_tetap, $data->kontrak],
            ]
        ];
    }

    public function updatedSelectedJenis()
    {
        $this->getDataset($this->jenis[$this->selectedJenis]);
        $this->emit('updateSDM', $this->dataset);
    }

    public function data($jenis)
    {
        $this->selectedJenis = $jenis;
        $this->getDataset($this->jenis[$this->selectedJenis]);
        // $this->emit('refreshSDM');
        $this->emit('updateSDM', $this->dataset);
    }
}
