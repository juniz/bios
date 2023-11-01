@extends('adminlte::page')

@section('title', 'SDM Laboratorium')

@section('content_header')
    <h1>Laboratorium</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Bidan" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/pranata_laboratorium' log='bios_log_laboratorium' bidang='PRANATA LABORATORIUM'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Bidan" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_laboratorium' url='kesehatan/sdm/pranata_laboratorium' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop