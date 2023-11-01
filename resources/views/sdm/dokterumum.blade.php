@extends('adminlte::page')

@section('title', 'SDM Dokter Umum')

@section('content_header')
    <h1>Dokter Umum</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Dokter Umum" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/dokter_umum' log='bios_log_dokter_umum' bidang='DOKTER UMUM'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Dokter Umum" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_dokter_umum' url='kesehatan/sdm/dokter_umum' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop