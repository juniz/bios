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
        </x-adminlte-card>
    </div>
    <div class="col-md-12">
        <x-adminlte-card title="Data Saldo Rekening - Operasional" theme="dark" theme-mode="outline">
            <livewire:operasional-table />
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