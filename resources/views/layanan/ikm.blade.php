@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Indeks Kepuasan Masyarakat (IKM)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Input Jumlah Indeks Kepuasan Masyarakat (IKM)" theme="dark" theme-mode="outline">
                <div class="row">
                    <x-adminlte-input id="indeks" name="indeks" label="Jumlah Nilai Indeks" type="number" value="0" fgroup-class="col-md-6" disable-feedback/>
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
             <x-adminlte-card title="Keterangan" theme="dark" theme-mode="outline">
                <ol>
                    @foreach($keterangan as $keterangan)
                        <li>{{ $keterangan }}</li>
                    @endforeach
                </ol>
            </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Data Jumlah Non-Medis Indeks Kepuasan Masyarakat (IKM)" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tableIKM" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @forelse($data as $data)
                        <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->tgl_transaksi }}</td>
                            <td>{{ $data->nilai_indeks }}</td>
                            <td>{{ $data->response }}</td>
                            <td>{{ $data->send_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Kosong</td>
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
                nilai_indeks:$("input[name=indeks]").val(),
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/ikm/kirim',
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