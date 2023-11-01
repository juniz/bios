@extends('adminlte::page')

@section('title', 'SDM Dokter Gigi')

@section('content_header')
    <h1>Dokter Gigi</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Dokter Gigi" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/dokter_gigi' log='bios_log_dokter_gigi' bidang='DOKTER GIGI'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Dokter Gigi" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_dokter_gigi' url='kesehatan/sdm/dokter_gigi' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop