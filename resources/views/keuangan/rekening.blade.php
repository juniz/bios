@extends('adminlte::page')

@section('title', 'Rekening')

@section('content_header')
<h1>Rekening</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Input Saldo Rekening - Dana Kelolaan" theme="dark" theme-mode="outline">
            <livewire:component.keuangan.rekening-form />
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Data Rekening" theme="dark" theme-mode="outline">
            <livewire:rekening-table />
        </x-adminlte-card>
    </div>
</div>

<x-adminlte-modal id="modalEditRekening" title="Ubah Rekening" v-centered>
    <livewire:component.keuangan.rekening-edit-form />
</x-adminlte-modal>

@stop

@section('plugins.Select2', true)

@push('js')
<script>
    Livewire.on('openModalRekeningEdit', (id) => {
        $('#modalEditRekening').modal('show');
    });
    Livewire.on('closeModalRekeningEdit', () => {
        $('#modalEditRekening').modal('hide');
    });
</script>
@endpush