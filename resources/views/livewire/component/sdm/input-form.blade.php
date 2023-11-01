<div>
    <form wire:init='init' wire:submit.prevent='simpan'>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                  <label for="pns">PNS</label>
                  <input type="text"
                    class="form-control" wire:model.defer='pns' name="pns" id="pns" aria-describedby="helpId" placeholder="">
                    @error('pns')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="p3k">P3K</label>
                  <input type="text"
                    class="form-control" wire:model.defer='p3k' name="p3k" id="p3k" aria-describedby="helpId" placeholder="">
                    @error('p3k')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="anggota">Anggota</label>
                  <input type="text"
                    class="form-control" wire:model.defer='anggota' name="anggota" id="anggota" aria-describedby="helpId" placeholder="">
                    @error('anggota')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                  <label for="non_pns">Non PNS Tetap</label>
                  <input type="text"
                    class="form-control" wire:model.defer='non_pns' name="non_pns" id="non_pns" aria-describedby="helpId" placeholder="">
                    @error('non_pns')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                  <label for="kontrak">Kontrak</label>
                  <input type="text"
                    class="form-control" wire:model.defer='kontrak' name="kontrak" id="kontrak" aria-describedby="helpId" placeholder="">
                    @error('kontrak')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="tgl_transaksi">Tgl Transaksi</label>
                  <input type="date"
                    class="form-control" wire:model.defer='tgl_transaksi' name="tgl_transaksi" id="tgl_transaksi" aria-describedby="helpId" placeholder="">
                    @error('tgl_transaksi')
                        <small id="helpId" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <button wire:loading.attr='disabled' type="submit" class="btn btn-primary btn-block">Simpan</button>
    </form>
</div>
