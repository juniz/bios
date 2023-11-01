@extends('adminlte::page')

@section('title', 'Scheduler')

@section('content_header')
    <h1>Scheduler</h1>
@stop

@section('content')
    <x-adminlte-card theme="dark" theme-mode="outline">
        <livewire:component.table-data database='monitored_scheduled_tasks' />
    </x-adminlte-card>
@stop

@section('css')
    
@stop

@section('js')
    
@stop