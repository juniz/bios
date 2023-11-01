<div>
    <div wire:init='load' class="table-responsive">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Tgl Transaksi</th>
                    <th>PNS</th>
                    <th>PPPK</th>
                    <th>Anggota</th>
                    <th>Non PNS</th>
                    <th>Kontrak</th>
                    <th>Response</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas as $data)
                <tr @if($data->response == 'MSG20003') class='bg-success' @else class='bg-danger' @endif>
                    <td>{{ $data->tgl_transaksi }}</td>
                    <td>{{ $data->pns }}</td>
                    <td>{{ $data->pppk }}</td>
                    <td>{{ $data->anggota }}</td>
                    <td>{{ $data->non_pns_tetap }}</td>
                    <td>{{ $data->kontrak }}</td>
                    <td>{{ $data->response }}</td>
                    <td>
                        <button
                            wire:loading.attr="disabled"
                            wire:click="kirim('{{ $data->tgl_transaksi }}', '{{ $data->pns }}', '{{ $data->pppk }}', '{{ $data->anggota }}', '{{ $data->non_pns_tetap }}', '{{ $data->kontrak }}')" 
                            class="btn btn-sm btn-outline btn-primary">
                                <i class="fas fa-send"></i>
                                Kirim
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if(!empty($datas))
        <div class="d-flex flex-row">
            <div class="mx-auto">
                {{ $datas->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
