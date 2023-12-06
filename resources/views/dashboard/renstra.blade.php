@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Renstra</h1>
@stop

@section('content')
<div class="d-flex flex-nowrap">
    <div class="col-md-3">
        <livewire:component.renstra.chart-head />
    </div>
</div>
@stop

@section('plugins.ApexChart', true)
@section('css')
    
@stop

@section('js')
    
@stop