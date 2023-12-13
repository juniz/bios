<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Kelolaan;

class KelolaanTable extends DataTableComponent
{
    protected $model = Kelolaan::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('tgl_transaksi', 'desc');
    }

    public function columns(): array
    {
        return [
            // Column::make("Id", "id")
            //     ->sortable(),
            Column::make("Tgl transaksi", "tgl_transaksi")
                ->sortable(),
            Column::make("Bank", "bank.uraian")
                ->sortable(),
            Column::make("No rekening", "rekening.nama")
                ->sortable(),
            Column::make("Saldo akhir", "saldo_akhir")
                ->sortable()
                ->format(fn($value, $row, Column $column)=> 'Rp. '. number_format($value, 2, ',', '.')),
            Column::make("Kode", "kode")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Response", "response")
                ->sortable(),
        ];
    }
}
