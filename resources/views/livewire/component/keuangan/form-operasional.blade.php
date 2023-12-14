<div>
    <form wire:submit.prevent='simpan'>
        <div class="row">
            <div class="col-6 col-md-6">
                <x-ui.select2 label="No Rekening" id="no_rekening" placeholder="Pilih Rekening ...." model="no_rekening">
                    <option value="">Pilih No Rekening</option>
                    @foreach ($listRekening as $item)
                        <option value="{{ $item->no_rek }}">{{ $item->no_rek }} - {{ $item->nama }}</option>
                    @endforeach
                </x-ui.select2>
            </div>
            <div class="col-6 col-md-6">
                <x-ui.select2 label="Kode Bank" id="kdbank" placeholder="Pilih Bank ...." model="kdbank">
                    <option value="">Pilih Kode Bank</option>
                    @foreach ($listBank as $item)
                        <option value="{{ $item->kode }}">{{ $item->uraian }}</option>
                    @endforeach
                </x-ui.select2>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-md-4">
                <x-ui.input label="Unit" id="unit" model="unit" />
            </div>
            <div class="col-6 col-md-4">
                <x-ui.input label="Saldo Akhir" id="saldo_akhir" model="saldo_akhir" />
            </div>
            <div class="col-md-4">
                <x-ui.input-datetime label="Tanggal Transaksi" id="tgl_transaksi" model="tgl_transaksi" />
            </div>
        </div>
        <button type="submit" class="btn btn-block btn-primary mt-3">Simpan</button>
    </form>
</div>

@push('js')
<script>
</script>
@endpush
