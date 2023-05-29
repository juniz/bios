@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Jumlah TOI (Turn Over Interval)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card theme="dark" theme-mode="outline">
                <div class="row">
                    <x-adminlte-input id="jumlah" name="jumlah" label="Jumlah TOI" type="number" value="0" fgroup-class="col-md-6" disable-feedback/>
                    <div class="col-md-6">
                        @php
                             $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date name="tanggal" label="Tanggal Transaksi" :config="$config" placeholder="Pilih Tanggal....">
                            <x-slot name="appendSlot">
                                <x-adminlte-button label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                </div>
             </x-adminlte-card>
             <x-adminlte-card theme="dark" theme-mode="outline">
                <ol>
                    @foreach($keterangan as $keterangan)
                        <li>{{ $keterangan }}</li>
                    @endforeach
                </ol>
            </x-adminlte-card>
        </div>
        <div class="col-md-12">
            <x-adminlte-card theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tableJumlahBOR" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @forelse($data as $data)
                        <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                            <td>{{ $data->tgl_transaksi }}</td>
                            <td>{{ $data->toi }}</td>
                            <td>{{ $data->response }}</td>
                            <td>{{ $data->send_at }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td>
                                <x-adminlte-button label="Kirim Ulang" onclick="kirimUlang('{{$data->tgl_transaksi}}','{{$data->toi}}')" class="btn-sm" icon="fas fa-lg fa-save"  />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data Kosong</td>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function kirimDataPerawat() {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                toi:$("input[name=jumlah]").val(),
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/toi/kirim',
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

        function kirimUlang(tgl,toi) {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:tgl,
                toi:toi,
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/toi/kirim',
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