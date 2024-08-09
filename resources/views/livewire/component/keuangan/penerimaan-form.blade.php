<div>
    <form wire:submit.prevent='simpan'>
        <x-ui.select2-row label="Akun" id="akun" model="kode_akun" placeholder="Pilih Akun ....">
            <option value="">Pilih Akun</option>
            @foreach ($listAkun as $item)
                <option value="{{ $item->kode }}">{{ $item->kode }} - {{ $item->uraian }}</option>
            @endforeach
        </x-ui.select2-row>
        <x-ui.input-row label="Jumlah" id="jumlah" type="number" model="jumlah" />
        <x-ui.input-datetime-row label="Tanggal Transaksi" id="tgl_transaksi" model="tgl_transaksi" />
        <button type="submit" class="btn btn-block btn-primary mt-3">Simpan</button>
    </form>
</div>
