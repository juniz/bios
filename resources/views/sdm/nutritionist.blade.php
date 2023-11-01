@extends('adminlte::page')

@section('title', 'SDM Nutritonist')

@section('content_header')
    <h1>Nutritonist</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Nutritonist" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/nutritionist' log='bios_log_nutritionist' bidang='NUTRITIONIST'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Nutritonist" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_nutritionist' url='kesehatan/sdm/nutritionist' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop