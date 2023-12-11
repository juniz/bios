<div>
    <div class="d-flex flex-row">
        <div class="ml-auto">
            <x-ui.input id="search" model="search" placeholder="Cari ......" />
        </div>
    </div>
    <x-ui.datatable :headers="['#', 'Tanggal', 'Pobo', 'Kode', 'Status', 'Response', 'Aksi']">
        @foreach($pobos as $pobo)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pobo->tgl_transaksi }}</td>
                <td>{{ $pobo->pobo }}</td>
                <td>{{ $pobo->kode }}</td>
                <td>{{ $pobo->status }}</td>
                <td>{{ $pobo->response }}</td>
                <td>
                    <button class="btn btn-sm btn-success" wire:click='edit("{{$pobo->tgl_transaksi}}", "{{$pobo->pobo}}")'>
                        <i class="fa fa-edit"></i> Edit
                    </button>
                </td>
            </tr>
        @endforeach
    </x-ui.datatable>
    <div class="d-flex flex-row">
        <div class="mx-auto">
            {{ $pobos->links() }}
        </div>
    </div>
</div>
