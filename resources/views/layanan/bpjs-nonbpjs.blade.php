@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Jumlah Pasien BPJS / Non-BPJS</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-adminlte-card title="Input Jumlah Pasien BPJS / Non-BPJS" theme="dark" theme-mode="outline">
                <div class="row">
                    <x-adminlte-input id="bpjs" name="bpjs" label="BPJS" type="number" value="{{$jumlah_BPJS}}" fgroup-class="col-md-6" disable-feedback/>
                    <x-adminlte-input id="non_bpjs" name="non_bpjs" label="Non BPJS" type="number" value="{{$jumlah_Non_BPJS}}" fgroup-class="col-md-6" disable-feedback/>
                </div>
                @php
                    $config = ['format' => 'YYYY-MM-DD'];
                @endphp
                <x-adminlte-input-date name="tanggal" value="{{$tanggal}}" label="Tanggal Transaksi" :config="$config" placeholder="Pilih Tanggal....">
                    <x-slot name="appendSlot">
                        <x-adminlte-button label="Cari" onclick="reload()" theme="success" />
                        <x-adminlte-button label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
                    </x-slot>
                </x-adminlte-input-date>
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
            <x-adminlte-card title="Data Jumlah Pasien BPJS / Non-BPJS" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tableBPJS" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @forelse($data as $data)
                        <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                            <td>{{ $data->tgl_transaksi }}</td>
                            <td>{{ $data->jumlah_bpjs }}</td>
                            <td>{{ $data->jumlah_non_bpjs }}</td>
                            <td>{{ $data->response }}</td>
                            <td>{{ $data->send_at }}</td>
                            <td>{{ $data->updated_at }}</td>
                            <td>
                                <x-adminlte-button label="Kirim Ulang" onclick="kirimUlang('{{$data->tgl_transaksi}}','{{$data->jumlah_bpjs}}','{{$data->jumlah_non_bpjs}}')" class="btn-sm" icon="fas fa-lg fa-save"  />
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

@section('css')
    
@stop

@section('js')
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>

        function reload(){
            let tgl = $("input[name=tanggal]").val();
            let url = "{{ url('/layanan/bpjs_non_bpjs') }}";
            location.href = url + '?tgl=' + tgl;
        }

        function kirimDataPerawat() {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                jumlah_bpjs:$("input[name=bpjs]").val(),
                jumlah_non_bpjs:$("input[name=non_bpjs]").val(),
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/bpjs_non_bpjs/kirim',
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