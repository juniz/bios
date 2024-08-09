<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Penerimaan;

class PenerimaanTable extends DataTableComponent
{
    protected $model = Penerimaan::class;

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
            Column::make("Kode Akun", "kode_akun")
                ->sortable(),
            Column::make("Nama Akun", "akun.uraian")
                ->sortable(),
            Column::make("Jumlah", "jumlah")
                ->format(fn($value, $row, Column $column)=> number_format($value, 2, ',', '.'))
                ->sortable(),
            Column::make("Kode", "kode")
                ->sortable(),
            Column::make("Status", "status")
                ->sortable()
                ->format(fn($value, $row, Column $column)=> '<span class="badge badge-'. ($value == 'MSG20003' ? 'success' : 'danger') .'">'. $value .'</span>')
                ->html(),
            Column::make("Response", "response")
                ->sortable(),
            // Column::make("Created at", "created_at")
            //     ->sortable(),
            // Column::make("Updated at", "updated_at")
            //     ->sortable(),
        ];
    }
}
