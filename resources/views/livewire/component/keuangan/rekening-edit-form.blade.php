<div>
    <form wire:submit.prevent='edit'>
        <x-ui.input label="No. Rekening" id="no_rek" type="text" model="no_rek" disabled />
        <x-ui.input label="Nama Rekening" id="nama" type="text" model="nama" />
        <button type="submit" class="btn btn-block btn-primary mt-3">Ubah</button>
    </form>
</div>
