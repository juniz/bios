@extends('adminlte::page')

@section('title', 'SDM Sanitarian')

@section('content_header')
    <h1>Sanitarian</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Sanitarian" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/sanitarian' log='bios_log_sanitarian' bidang='SANITARIAN'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Sanitarian" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_sanitarian' url='kesehatan/sdm/sanitarian' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop