@extends('adminlte::page')

@section('title', 'SDM Perawat')

@section('content_header')
    <h1>Perawat</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Perawat" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/perawat' log='bios_log_perawat' bidang='PERAWAT'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Perawat" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_perawat' url='kesehatan/sdm/perawat' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop