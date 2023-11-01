@extends('adminlte::page')

@section('title', 'SDM Radiographer')

@section('content_header')
    <h1>Radiographer</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Radiographer" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/radiographer' log='bios_log_radiographer' bidang='RADIOGRAFER'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Radiographer" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_radiographer' url='kesehatan/sdm/radiographer' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop