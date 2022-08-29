@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <x-adminlte-card theme="lime" theme-mode="outline">
       <div class="row">
            <x-adminlte-input name="pns" label="Jumlah PNS" type="number" fgroup-class="col-md-2" disable-feedback/>
            <x-adminlte-input name="pppk" label="Jumlah P3K" type="number" fgroup-class="col-md-2" disable-feedback/>
            <x-adminlte-input name="anggota" label="Jumlah POLRI" type="number" fgroup-class="col-md-3" disable-feedback/>
            <x-adminlte-input name="non_pns" label="Jumlah PNS Tetap" type="number" fgroup-class="col-md-3" disable-feedback/>
            <x-adminlte-input name="kontrak" label="Jumlah Kontrak" type="number" fgroup-class="col-md-2" disable-feedback/>
       </div>
       <div class="d-flex flex-row-reverse">
            <div class="p-1">
                <x-adminlte-button label="Kirim" theme="primary" />
            </div>
            <div class="p-1">
                <x-adminlte-button label="Refresh" theme="success" />
            </div>
            <div class="p-2">
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date name="tanggal" :config="$config" placeholder="Pilih Tanggal....">
                    <x-slot name="appendSlot">
                        <div class="input-group-text bg-gradient-danger">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-date>
            </div>
       </div>
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop