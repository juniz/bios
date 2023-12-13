<?php

namespace App\Http\Livewire\Component;

use App\Models\Operasional;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OperasionalWidget extends Component
{
    public array $label = [];
    public array $dataset = [];

    public function render()
    {
        return view('livewire.component.operasional-widget');
    }

    public function mount()
    {
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
        return ['RPL 034 BLU RS BHAYANGKARA NGANJUK UTK OPS', 'RPL 034 BLU RSB NGANJUK UTK OPS', 'RPL 034 RS BHAYANGKARA NGANJUK DANA KEGIATAN RUMKIT', 'RPL 034 RS BHAYANGKARA NGANJUK UANG MUKA', 'RPL 034 RS BHAYANGKARA NGANJUK OPERASIONAL PENGELUARAN'];
    }

    public function getData($rek)
    {
        $data = Operasional::where('no_rekening', $rek)->orderByDesc('tgl_transaksi')->first();
        return $data->saldo_akhir;
    }

    public function getDataset()
    {
        $this->dataset = [
            [
                'backgroundColor' => ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                'hoverBackgroundColor' => ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e74a3b'],
                'data' => [
                    $this->getData('005601002334303') ?? 0, 
                    $this->getData('005601003859306') ?? 0, 
                    $this->getData('0128811573') ?? 0, 
                    $this->getData('8686575888') ?? 0, 
                    $this->getData('8686575899') ?? 0, 
                ],
            ]
        ];
    }

    public function data()
    {
        $this->getDataset();
        // $this->emit('refreshSDM');
        $this->emit('updateOperasional', $this->dataset);
    }
}
