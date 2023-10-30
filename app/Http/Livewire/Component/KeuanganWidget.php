<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class KeuanganWidget extends Component
{
    public array $label = [];
    public array $years = [];
    public array $dataset = [];
    public $selectedYear;

    public function mount()
    {
        $this->years = $this->getYears();
        $this->selectedYear = Carbon::today()->format('Y');
        $this->label = $this->getLabel();
        // $this->dataset = $this->dataset($this->selectedYear) ?? [];
        $this->dataset =  [
            [
                'label' => 'Penerimaan',
                'borderColor' => "rgb(62,149,205)",
                'backgroundColor' => "rgb(62,149,205,0.1)",
                'data' => [0,0,0,0,0,0,0,0,0,0,0,0],
            ],
            [
                'label' => 'Pengeluaran',
                'borderColor' => "rgb(196,88,80)",
                'backgroundColor' => "rgb(196,88,80,0.1)",
                'data' => [0,0,0,0,0,0,0,0,0,0,0,0],
            ]
        ];
    }

    public function render()
    {
        return view('livewire.component.keuangan-widget');
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

    public function updatedSelectedYear()
    {
        $this->dataset();
    }

    public function getData($database, $month, $year)
    {
        $data = [];
        for($i = 1; $i <= 13; $i++) {
            $data = DB::table($database)
                    ->where('tgl_transaksi', 'like', $year.'-'.$month.'%')
                    ->groupBy(DB::raw('MONTH(tgl_transaksi)'))
                    ->sum('jumlah');
        }
        return $data;
    }

    public function dataset()
    {
        $year = $this->selectedYear;
        $data = [];
        $pengeluaran = [];
        for ($i = 1; $i < 13; $i++) {
            $month = date('m', mktime(0,0,0,$i, 1, $year));
            $data[] = $this->getData('bios_log_penerimaan', $month, $year);
            $pengeluaran[] = $this->getData('bios_log_pengeluaran', $month, $year);
        }
        $datasets = [
            [
                'label' => 'Penerimaan',
                'borderColor' => "rgb(62,149,205)",
                'backgroundColor' => "rgb(62,149,205,0.1)",
                'data' => $data,
            ],
            [
                'label' => 'Pengeluaran',
                'borderColor' => "rgb(196,88,80)",
                'backgroundColor' => "rgb(196,88,80,0.1)",
                'data' => $pengeluaran,
            ]
        ];
        $this->emit('updateKeuanganChart', $datasets);
    }
}
