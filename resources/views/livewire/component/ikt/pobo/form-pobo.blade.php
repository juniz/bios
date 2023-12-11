<div>
    <form wire:submit.prevent='simpan'>
        <div class="row">
            <div class="col-6 col-md-6">
                <x-ui.input-datetime label="Tanggal Transaksi" id="tgl_transaksi" model="tgl_transaksi" />
            </div>
            <div class="col-6 col-md-6">
                <x-ui.input label="POBO" id="pobo" model="pobo" />
            </div>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary btn-block" type="submit">Simpan</button>
        </div>
    </form>
</div>
