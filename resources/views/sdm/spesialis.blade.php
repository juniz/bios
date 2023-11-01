@extends('adminlte::page')

@section('title', 'SDM Dokter Spesialist')

@section('content_header')
    <h1>Dokter Spesialist</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Dokter Spesialist" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/dokter_spesialis' log='bios_log_spesialis' bidang='DOKTER SPESIALIS'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Dokter Spesialist" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_spesialis' url='kesehatan/sdm/dokter_spesialis' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop