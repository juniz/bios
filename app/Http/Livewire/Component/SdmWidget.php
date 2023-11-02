<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SdmWidget extends Component
{
    public array $label = [];
    public array $dataset = [];
    public array $years = [];
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
    public $selectedYear;

    public function render()
    {
        return view('livewire.component.sdm-widget');
    }

    public function mount()
    {
        $this->years = $this->getYears();
        $this->selectedYear = Carbon::today()->format('Y');
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

    public function getYears()
    {
        $years = [];
        for ($i = 0; $i < 5; $i++) {
            $years[] = Carbon::today()->subYear($i)->format('Y');
        }
        return $years;
    }

    public function getLabel()
    {
        return ['PNS', 'PPPK', 'Anggota', 'Non PNS Tetap', 'Kontrak'];
    }

    public function getData($database)
    {
        return DB::table($database)
                    ->where('tgl_transaksi', 'like', $this->selectedYear.'%')
                    ->orderByDesc('tgl_transaksi')
                    ->first();
    }

    public function getDataset($database)
    {
        $data = $this->getData($database);
        $this->dataset = [
            [
                'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e74a3b'],
                'data' => [$data->pns ?? 0, $data->pppk ?? 0, $data->anggota ?? 0, $data->non_pns_tetap ?? 0, $data->kontrak ?? 0],
            ]
        ];
    }

    public function updatedSelectedJenis()
    {
        $this->getDataset($this->jenis[$this->selectedJenis]);
        $this->emit('updateSDM', $this->dataset);
    }

    public function updatedSelectedYear()
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
