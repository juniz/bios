@extends('adminlte::page')

@section('title', 'SDM Profesional Lainnya')

@section('content_header')
    <h1>Profesional Lainnya</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Profesional Lainnya" theme="dark" theme-mode="outline">
       <livewire:component.sdm.input-form url='kesehatan/sdm/profesional_lain' log='bios_log_profesional_lainnya' bidang='TENAGA PROFESIONAL LAINNYA'>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Profesional Lainnya" theme="dark" theme-mode="outline">
        <livewire:component.sdm.table table='bios_log_profesional_lainnya' url='kesehatan/sdm/profesional_lain' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop