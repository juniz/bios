@extends('adminlte::page')

@section('title', 'SDM Administrasi')

@section('content_header')
    <h1>Administrasi</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Administrasi" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/non_medis_administrasi' log='bios_log_administrasi' bidang='TENAGA NON MEDIS ADMINISTRASI'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Administrasi" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_administrasi' url='kesehatan/sdm/non_medis_administrasi' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop