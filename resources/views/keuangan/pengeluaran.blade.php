@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Pengeluaran</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Input Pengeluaran" theme="dark" theme-mode="outline">
            <div class="col-md-12">
                <x-adminlte-select2 name="kd_akun" label="Akun"
                    data-placeholder="6 digit kode akun diawali dengan angka 5">
                    <option />
                    @foreach($akun as $akun)
                    <option value="{{$akun['kode']}}"><b>{{$akun['kode']}}</b> - {{$akun['uraian']}}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
            <x-adminlte-input id="jumlah" name="jumlah" label="Jumlah" type="number" fgroup-class="col-md-12"
                disable-feedback />
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
            <x-adminlte-button class="btn-block" label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
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
        <x-adminlte-card title="Data Pengeluaran" theme="dark" theme-mode="outline">
            @php
            $config = [
            'order' => [[0, 'desc']],
            "responsive" => true,
            ];
            @endphp
            <x-adminlte-datatable id="tablePenerimaan" :heads="$head" head-theme="dark" :config="$config" striped
                hoverable bordered compressed>
                @forelse($data as $data)
                <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                    <td>{{ $data->tgl_transaksi }}</td>
                    <td>{{ $data->kd_akun }}</td>
                    <td>{{ $data->jumlah }}</td>
                    <td>{{ $data->response }}</td>
                    <td>{{ $data->send_at }}</td>
                    <td>{{ $data->updated_at }}</td>
                    <td>
                        <x-adminlte-button label="Kirim Ulang"
                            onclick="kirimUlang('{{$data->tgl_transaksi}}','{{$data->kd_akun}}','{{$data->jumlah}}')"
                            class="btn-sm" icon="fas fa-lg fa-save" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Data Kosong</td>
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
                kd_akun:$("select[name=kd_akun]").val(),
                jumlah:$("input[name=jumlah]").val(),
            };

            $.ajax({
                type:'POST',
                url:'/keuangan/pengeluaran/kirim',
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

    function kirimUlang(tgl,akun,jumlah) {
        let data = {
            _token:$('meta[name="csrf-token"]').attr('content'),
            tgl_transaksi:tgl,
            kd_akun:akun,
            jumlah:jumlah,
        };

        $.ajax({
            type:'POST',
            url:'/keuangan/pengeluaran/kirim',
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