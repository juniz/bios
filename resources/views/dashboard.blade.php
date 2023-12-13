@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Selamat Datang,</br> {{$nama}} </h1>
@stop

@section('content')
<livewire:component.saldo-widget />
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <livewire:component.operasional-widget />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <x-adminlte-card class="h-100">
            <livewire:component.sdm-widget />
        </x-adminlte-card>
    </div>
    <div class="col-md-7">
        <x-adminlte-card class="h-100">
            <livewire:component.keuangan-widget />
        </x-adminlte-card>
    </div>
</div>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <livewire:component.kunjungan-rajal-widget />
            </div>
        </div>
    </div>
</div>
@stop

@section('plugins.Chartjs', true)
@section('css')
    
@stop

@section('js')
    
@stop