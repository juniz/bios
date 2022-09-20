@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dokter Gigi</h1>
@stop

@section('content')
    <x-adminlte-card title="Input Jumlah Dokter Gigi" theme="dark" theme-mode="outline">
        <div class="row">
            <x-adminlte-input id="pns" name="pns" label="Jumlah PNS" value="{{$pns}}" type="number" fgroup-class="col-md-2" disable-feedback/>
            <x-adminlte-input id="pppk" name="pppk" label="Jumlah P3K" value="{{$p3k}}" type="number" fgroup-class="col-md-2" disable-feedback/>
            <x-adminlte-input id="anggota" name="anggota" label="Jumlah Anggota" value="{{$anggota}}" type="number" fgroup-class="col-md-3" disable-feedback/>
            <x-adminlte-input id="non_pns" name="non_pns" label="Jumlah Non PNS Tetap" value="{{$non_pns}}" type="number" fgroup-class="col-md-3" disable-feedback/>
            <x-adminlte-input id="kontrak" name="kontrak" label="Jumlah Kontrak" value="{{$kontrak}}" type="number" fgroup-class="col-md-2" disable-feedback/>
       </div>
       <div class="d-flex flex-row-reverse">
        <div class="p-2">
            @php
                $config = ['format' => 'YYYY-MM-DD'];
            @endphp
            <x-adminlte-input-date name="tanggal" value="{{$tanggal}}" :config="$config" placeholder="Pilih Tanggal....">
                <x-slot name="appendSlot">
                    <x-adminlte-button label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
                </x-slot>
            </x-adminlte-input-date>
        </div>
    </div>
    </x-adminlte-card>

    <x-adminlte-card title="Data Jumlah Dokter Gigi" theme="dark" theme-mode="outline">
        @php
            $config = [
                'order' => [[0, 'desc']],
                "responsive" => true,
            ];
        @endphp
        <x-adminlte-datatable id="tableDokterGigi" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
            @if(!empty($data['data']['datas']))
                @foreach($data['data']['datas'] as $row)
                    <tr>
                        <td>{{ $row['tgl_transaksi'] }}</td>
                        <td>{{ $row['updated_at'] }}</td>
                        <td>{{ $row['pns'] }}</td>
                        <td>{{ $row['pppk'] }}</td>
                        <td>{{ $row['non_pns_tetap'] }}</td>
                        <td>{{ $row['kontrak'] }}</td>
                        <td>{{ $row['anggota'] }}</td>
                    </tr>
                @endforeach
            @endif
        </x-adminlte-datatable>
    </x-adminlte-card>
    <x-adminlte-card title="Keterangan" theme="dark" theme-mode="outline">
        <ol>
            @foreach($keterangan as $keterangan)
                <li>{{ $keterangan }}</li>
            @endforeach
        </ol>
    </x-adminlte-card>
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
                pns:$("input[name=pns]").val(),
                pppk:$("input[name=pppk]").val(),
                anggota:$("input[name=anggota]").val(),
                non_pns_tetap:$("input[name=non_pns]").val(),
                kontrak:$("input[name=kontrak]").val(),
            };
            console.log(data);
            $.ajax({
                type:'POST',
                url:'/sdm/doktergigi/kirim',
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