@extends('adminlte::page')

@section('title', 'SDM Bidan')

@section('content_header')
    <h1>Bidan</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Bidan" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/bidan' log='bios_log_bidan' bidang='BIDAN'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Bidan" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_bidan' url='kesehatan/sdm/bidan' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop