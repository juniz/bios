@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Saldo Rekening - Pengelolaan Kas</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <x-adminlte-card title="Saldo Rekening - Pengelolaan Kas" theme="dark" theme-mode="outline">
            <x-adminlte-input id="no_bilyet" name="no_bilyet" label="No. Bilyet" type="number" fgroup-class="col-md-12"
                disable-feedback />
            <x-adminlte-input id="nilai_bunga" name="nilai_bunga" label="Nilai Bunga"
                placeholder="Nilai uang, bukan persentase bunga" type="number" fgroup-class="col-md-12"
                disable-feedback />
            <x-adminlte-input id="nilai_deposito" name="nilai_deposito" label="Nilai Deposito" type="number"
                fgroup-class="col-md-12" disable-feedback />
            @php
            $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggal" label="Tanggal Transaksi" :config="$config"
                placeholder="Pilih Tanggal....">
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
        <x-adminlte-card title="Saldo Rekening - Pengelolaan Kas" theme="dark" theme-mode="outline">
            @php
            $config = [
            'order' => [[0, 'desc']],
            "responsive" => true,
            ];
            @endphp
            <x-adminlte-datatable id="tableKas" :heads="$head" head-theme="dark" :config="$config" striped hoverable
                bordered compressed>
                @forelse($data as $data)
                <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                    <td>{{ $data->tgl_transaksi }}</td>
                    <td>{{ $data->no_bilyet }}</td>
                    <td>{{ $data->nilai_bunga }}</td>
                    <td>{{ $data->nilai_deposito }}</td>
                    <td>{{ $data->response }}</td>
                    <td>{{ $data->send_at }}</td>
                    <td>{{ $data->updated_at }}</td>
                    <td>
                        <x-adminlte-button label="Kirim Ulang"
                            onclick="kirimUlang('{{$data->tgl_transaksi}}','{{$data->no_bilyet}}','{{$data->nilai_bunga}}','{{$data->nilai_deposito}}')"
                            class="btn-sm" icon="fas fa-lg fa-save" />
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Data Kosong</td>
                </tr>
                @endforelse
            </x-adminlte-datatable>
        </x-adminlte-card>
    </div>
</div>
@stop


@section('css')

@stop

@section('js')
{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
<script>
    function kirimDataPerawat() {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                no_bilyet:$("input[name=no_bilyet]").val(),
                nilai_deposito:$("input[name=nilai_deposito]").val(),
                nilai_bunga:$("input[name=nilai_bunga]").val(),
            };

            $.ajax({
                type:'POST',
                url:'/keuangan/kas/kirim',
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

    function kirimUlang(tgl, bilyet, bunga, deposito) {
        let data = {
            _token:$('meta[name="csrf-token"]').attr('content'),
            tgl_transaksi:tgl,
            no_bilyet:bilyet,
            nilai_deposito:deposito,
            nilai_bunga:bunga,
        };
        // console.log(data);
        $.ajax({
            type:'POST',
            url:'/keuangan/kas/kirim',
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