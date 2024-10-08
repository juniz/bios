@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Saldo Rekening - Operasional</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Input Saldo Rekening - Operasional" theme="dark" theme-mode="outline">
            <livewire:component.keuangan.form-operasional />
            {{-- <x-adminlte-input id="no_rekening" name="no_rekening" label="No. Rekening" type="text"
                fgroup-class="col-md-12" disable-feedback />
            {{-- <x-adminlte-select2 name="no_rekening" label="No. Rekening" data-placeholder="Pilih No. Rekening.......">
                <option />
                @foreach($rekening as $rek)
                <option value="{{$rek->no_rek}}"><b>{{$rek->no_rek}}</b> - {{$rek->nama}}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-select2 name="kdbank" label="Bank" data-placeholder="Pilih Bank.......">
                <option />
                @foreach($bank as $bank)
                <option value="{{$bank['kode']}}"><b>{{$bank['kode']}}</b> - {{$bank['uraian']}}</option>
                @endforeach
            </x-adminlte-select2>
            <div class="row">
                <x-adminlte-input id="unit" name="unit" value="RS BHAYANGKARA NGANJUK" label="Unit" type="text"
                    fgroup-class="col-md-12" disable-feedback />
                <x-adminlte-input id="saldo_akhir" name="saldo_akhir" label="Saldo Akhir" type="number" value="0"
                    fgroup-class="col-md-12" disable-feedback />
            </div>
            @php
            $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggal" label="Tanggal Transaksi" :config="$config"
                placeholder="Pilih Tanggal....">
                <x-slot name="appendSlot">
                    <div class="input-group-text bg-dark">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </x-slot>
            </x-adminlte-input-date>
            <x-adminlte-button class="btn-block" label="Kirim" onclick="kirimDataPerawat()" theme="primary" /> --}}
        </x-adminlte-card>
        <x-adminlte-card title="Keterangan" theme="dark" theme-mode="outline">
            <ol>
                @foreach($keterangan as $keterangan)
                <li>{{ $keterangan }}</li>
                @endforeach
            </ol>
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Data Saldo Rekening - Operasional" theme="dark" theme-mode="outline">
            @php
            $config = [
            'order' => [[0, 'desc']],
            "responsive" => true,
            ];
            @endphp
            <x-adminlte-datatable id="tableOperasional" :heads="$head" head-theme="dark" :config="$config" striped
                hoverable bordered compressed>
                @forelse($data as $data)
                <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                    <td>{{ $data->tgl_transaksi }}</td>
                    <td>{{ $data->no_rekening }}</td>
                    <td>{{ $data->kdbank }}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ $data->saldo_akhir }}</td>
                    <td>{{ $data->response }}</td>
                    <td>{{ $data->send_at }}</td>
                    <td>{{ $data->updated_at }}</td>
                    <td>
                        <x-adminlte-button label="Kirim Ulang"
                            onclick="kirimUlang('{{$data->tgl_transaksi}}','{{$data->no_rekening}}','{{$data->kdbank}}', '{{$data->unit}}', '{{$data->saldo_akhir}}')"
                            class="btn-sm" icon="fas fa-lg fa-save" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('plugins.Select2', true)

@section('css')

@stop

@section('js')
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    function kirimDataPerawat() {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                no_rekening:$("select[name=no_rekening]").val(),
                unit:$("input[name=unit]").val(),
                saldo_akhir:$("input[name=saldo_akhir]").val(),
                kdbank:$("select[name=kdbank]").val(),
            };

            $.ajax({
                type:'POST',
                url:'/keuangan/operasional/kirim',
                data:data,
                dataType:'json',
                beforeSend:function() {
                    Swal.fire({
                        title: 'Loading....',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success:function(response) {
                    console.log(response);
                    if(response.status == 'MSG20003'){
                        Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                        }).then((result) => {
                            window.location.reload();
                            });
                    }else{
                        Swal.fire({
                        icon: 'error',
                        title: response.message,
                        text: JSON.stringify(response.error),
                        showConfirmButton: true,
                        });
                    }
                },
                error:function(error){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Opsss Terjadi Kesalahan',
                        showConfirmButton: true,
                        });
                }
            });
        }

    function kirimUlang(tgl, no_rekening, kdbank, unit, saldo_akhir) {
        let data = {
            _token:$('meta[name="csrf-token"]').attr('content'),
            tgl_transaksi:tgl,
            no_rekening:no_rekening,
            unit:unit,
            saldo_akhir:saldo_akhir,
            kdbank:kdbank,
        };

        $.ajax({
            type:'POST',
            url:'/keuangan/operasional/kirim',
            data:data,
            dataType:'json',
            beforeSend:function() {
                Swal.fire({
                    title: 'Loading....',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success:function(response) {
                console.log(response);
                if(response.status == 'MSG20003'){
                    Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                    }).then((result) => {
                        window.location.reload();
                        });
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: response.message,
                    text: JSON.stringify(response.error),
                    showConfirmButton: true,
                    });
                }
            },
            error:function(error){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Opsss Terjadi Kesalahan',
                    showConfirmButton: true,
                    });
            }
        });
    }
</script>
@stop