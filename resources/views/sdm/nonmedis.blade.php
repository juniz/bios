@extends('adminlte::page')

@section('title', 'SDM Non Medis')

@section('content_header')
    <h1>Non Medis</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Non Medis" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/non_medis' log='bios_log_non_medis' bidang='TENAGA NON MEDIS'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Non Medis" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_non_medis' url='kesehatan/sdm/non_medis' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop