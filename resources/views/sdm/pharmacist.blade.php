@extends('adminlte::page')

@section('title', 'SDM Pharmacist')

@section('content_header')
    <h1>Pharmacist</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Pharmacist" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/pharmacist' log='bios_log_pharmacist' bidang='PHARMACIST'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Pharmacist" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_pharmacist' url='kesehatan/sdm/pharmacist' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop