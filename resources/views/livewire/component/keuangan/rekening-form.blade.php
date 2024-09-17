<div>
    <form wire:submit.prevent='store'>
    <x-ui.input-row label="No. Rekening" id="no_rek" type="text" model="no_rek" />
    <x-ui.input-row label="Nama Rekening" id="nama" type="text" model="nama" />
    <button type="submit" class="btn btn-block btn-primary mt-3">Simpan</button>
    </form>
</div>
