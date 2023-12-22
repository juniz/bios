<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class KunjunganRajalWidget extends Component
{
    public array $label = [];
    public array $years = [];
    public array $dataset = [];
    public $jenis = [
        'bios_log_ralan' => 'Rawat Jalan',
        'bios_log_ranap' => 'Rawat Inap',
        'bios_log_igd' => 'IGD',
        'bios_log_farmasi' => 'Farmasi',
        'bios_log_radiologi' => 'Radiologi',
        'bios_log_lab_sample' => 'Laboratorium',
        'bios_log_bor' => 'BOR',
        'bios_log_alos' => 'ALOS',
        'bios_log_toi' => 'TOI',
    ];
    public $selectedYear, $selectedJenis, $labelName, $database;

    public function mount()
    {
        $this->years = $this->getYears();
        $this->selectedYear = Carbon::today()->format('Y');
        $this->selectedJenis = 'bios_log_ralan';
        $this->labelName = 'Pasien Rawat Jalan';
        $this->database = $this->jenis[$this->selectedJenis];
        $this->label = $this->getLabel();
        $this->dataset =  [
            [
                'label' => $this->labelName,
                'borderColor' => "rgb(62,149,205)",
                'backgroundColor' => "rgb(62,149,205)",
                'data' => [0,0,0,0,0,0,0,0,0,0,0,0],
            ]
        ];
    }

    public function render()
    {
        return view('livewire.component.kunjungan-rajal-widget');
    }

    public function updatedSelectedYear()
    {
        $this->dataset();
    }

    public function updatedSelectedJenis()
    {
        $this->database = $this->jenis[$this->selectedJenis];
        $this->labelName = 'Pasien '.Arr::get($this->jenis, $this->selectedJenis);
        $this->dataset();
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
        $labels = [];
        for ($i = 1; $i < 13; $i++) {
            $labels[] = date('F', mktime(0,0,0,$i, 1, date('Y')));
        } 
        return $labels;
    }

    public function getData($database, $month, $year)
    {
        $data = [];
        if($database == 'bios_log_toi'){
                for($i = 1; $i <= 13; $i++) {
                    $data = DB::table($database)
                            ->where('tgl_transaksi', 'like', $year.'-'.$month.'%')
                            ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                            ->sum('toi');
                }
        }else if($database == 'bios_log_alos'){
            for($i = 1; $i <= 13; $i++) {
                $data = DB::table($database)
                        ->where('tgl_transaksi', 'like', $year.'-'.$month.'%')
                        ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                        ->sum('alos');
            }
        }else if($database == 'bios_log_bor'){
            for($i = 1; $i <= 13; $i++) {
                $data = DB::table($database)
                        ->where('tgl_transaksi', 'like', $year.'-'.$month.'%')
                        ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                        ->sum('bor');
            }
        }else{
            for($i = 1; $i <= 13; $i++) {
                $data = DB::table($database)
                        ->where('tgl_transaksi', 'like', $year.'-'.$month.'%')
                        ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                        ->sum('jumlah');
            }
        }
        return $data;
    }

    public function dataset()
    {
        $year = $this->selectedYear;
        $data = [];
        for ($i = 1; $i < 13; $i++) {
            $month = date('m', mktime(0,0,0,$i, 1, $year));
            $data[] = $this->getData($this->selectedJenis , $month, $year);
        }
        $datasets = [
            [
                'label' => $this->labelName,
                'borderColor' => "rgb(62,149,205)",
                'backgroundColor' => "rgb(62,149,205)",
                'data' => $data,
            ],
        ];
        $this->emit('updateRalanChart', $datasets);
    }
}
