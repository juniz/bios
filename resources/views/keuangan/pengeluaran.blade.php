@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Pengeluaran</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Input Pengeluaran" theme="dark" theme-mode="outline">
                <div class="col-md-12">
                    <x-adminlte-select2 name="kd_akun" label="Akun" data-placeholder="6 digit kode akun diawali dengan angka 5" >
                        <option/>
                        @foreach($akun as $akun)
                            <option value="{{$akun['kode']}}"><b>{{$akun['kode']}}</b> - {{$akun['uraian']}}</option>
                        @endforeach
                    </x-adminlte-select2>
                </div>
                <x-adminlte-input id="jumlah" name="jumlah" label="Jumlah" type="number" fgroup-class="col-md-12" disable-feedback/>
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date name="tanggal" label="Tanggal Transaksi" :config="$config" placeholder="Pilih Tanggal....">
                    <x-slot name="appendSlot">
                        <x-adminlte-button label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
                    </x-slot>
                </x-adminlte-input-date>
             </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Data Pengeluaran" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tablePenerimaan" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @if(!empty($data['data']['datas']))
                        @foreach($data['data']['datas'] as $row)
                            <tr>
                                <td>{{ $row['tgl_transaksi'] }}</td>
                                <td>{{ $row['kd_akun'] }}</td>
                                <td>{{ $row['jumlah'] }}</td>
                            </tr>
                        @endforeach
                    @endif
                </x-adminlte-datatable>
            </x-adminlte-card>
        </div>
    </div>
@stop

@section('plugins.Select2', true)

@section('css')
    
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    </script>
@stop