<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Str;
use App\Models\Rekening;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RekeningTable extends DataTableComponent
{
    use LivewireAlert;
    protected $model = Rekening::class;

    public function configure(): void
    {
        $this->setPrimaryKey('no_rek');
        $this->setDefaultSort('no_rek', 'asc');
    }

    public function openRekeningEdit($no_rek)
    {
        // dd($no_rek);
        $this->emit('openRekeningEditForm', $no_rek);
    }

    public function hapus($no_rek)
    {
        try {
            $rekening = Rekening::find($no_rek);
            $rekening->delete();
            $this->alert('success', 'Data berhasil dihapus');
            $this->emit('refreshDatatable');
        } catch (\Exception $e) {
            $this->alert('error', 'Data gagal dihapus : ' . $e->getMessage());
        }
    }

    public function columns(): array
    {
        return [
            Column::make("No rek", "no_rek")
                ->format(fn($value, $row, Column $column) => '<span>' . $row->no_rek . '</span>')
                ->html()
                ->sortable(),
            Column::make("Nama", "nama")
                ->sortable(),
            Column::make("Action", "no_rek")
                ->format(function ($value, $row, Column $column) {
                    $data = "'$value'";
                    return '
                    <button class="btn btn-sm btn-primary" wire:click="openRekeningEdit(' . $data . ')">Edit</button>
                    <button class="btn btn-sm btn-danger" wire:click="hapus(' . $data . ')">Hapus</button>
                    ';
                })
                ->html(),
        ];
    }
}
