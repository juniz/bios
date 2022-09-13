@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Saldo Rekening - Operasional</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Input Saldo Rekening - Operasional" theme="dark" theme-mode="outline">
                <div class="row">
                    <x-adminlte-input id="no_rekening" name="no_rekening" label="No. Rekening" type="text" fgroup-class="col-md-6" disable-feedback/>
                    <x-adminlte-input id="unit" name="unit" label="Unit" type="text" fgroup-class="col-md-6" disable-feedback/>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <x-adminlte-select2 name="kdbank" label="Bank" data-placeholder="Pilih Bank......." >
                            <option/>
                            @foreach($bank as $bank)
                                <option value="{{$bank['kode']}}"><b>{{$bank['kode']}}</b> - {{$bank['uraian']}}</option>
                            @endforeach
                        </x-adminlte-select2>
                    </div>
                    <x-adminlte-input id="saldo_akhir" name="saldo_akhir" label="Saldo Akhir" type="number" value="0" fgroup-class="col-md-6" disable-feedback/>
                </div>
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
            <x-adminlte-card title="Data Saldo Rekening - Operasional" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tableOperasional" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @if(!empty($data['data']['datas']))
                        @foreach($data['data']['datas'] as $row)
                            <tr>
                                <td>{{ $row['tgl_transaksi'] }}</td>
                                <td>{{ $row['no_rekening'] }}</td>
                                <td>{{ $row['kdbank'] }}</td>
                                <td>{{ $row['unit'] }}</td>
                                <td>{{ $row['saldo_akhir'] }}</td>
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
                no_rekening:$("input[name=no_rekening]").val(),
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
    </script>
@stop