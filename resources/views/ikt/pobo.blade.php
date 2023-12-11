@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Rasio POBO</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Input Rasio POBO" theme="dark" theme-mode="outline">
                <livewire:component.ikt.pobo.form-pobo />
             </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <x-adminlte-card title="Data Rasio POBO" theme="dark" theme-mode="outline">
                <livewire:component.ikt.pobo.table-pobo />
            </x-adminlte-card>
        </div>
    </div>

@stop
