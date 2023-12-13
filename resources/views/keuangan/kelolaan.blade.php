@extends('adminlte::page')

@section('title', 'Dana Kelolaan')

@section('content_header')
<h1>Saldo Rekening - Dana Kelolaan</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Input Saldo Rekening - Dana Kelolaan" theme="dark" theme-mode="outline">
            <livewire:component.keuangan.kelolaan-form />
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Data Saldo Rekening - Dana Kelolaan" theme="dark" theme-mode="outline">
            <livewire:kelolaan-table />
        </x-adminlte-card>
    </div>
</div>
@stop

@section('plugins.Select2', true)