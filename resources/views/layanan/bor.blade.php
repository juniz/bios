@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Jumlah BOR (Bed Occupancy Ratio)</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Input Jumlah BOR (Bed Occupancy Ratio)" theme="dark" theme-mode="outline">
                <div class="row">
                    <x-adminlte-input id="jumlah" name="jumlah" label="Jumlah BOR" type="number" value="0" fgroup-class="col-md-6" disable-feedback/>
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
            <x-adminlte-card title="Data Jumlah BOR (Bed Occupancy Ratio)" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tableJumlahBOR" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @if(!empty($data['data']['datas']))
                        @foreach($data['data']['datas'] as $row)
                            <tr>
                                <td>{{ $row['tgl_transaksi'] }}</td>
                                <td>{{ $row['bor'] }}</td>
                            </tr>
                        @endforeach
                    @endif
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
                bor:$("input[name=jumlah]").val(),
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/bor/kirim',
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