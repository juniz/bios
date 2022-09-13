@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Jumlah Pasien Rawat Jalan/Poli</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <x-adminlte-card title="Input Jumlah Pasien Rawat Jalan/Poli" theme="dark" theme-mode="outline">
                <div class="row">
                    <div class="col-md-10">
                        @php
                            $config = ['format' => 'YYYY-MM-DD'];
                        @endphp
                        <x-adminlte-input-date name="tanggal" value="{{$tanggal}}" :config="$config" placeholder="Pilih Tanggal....">
                            <x-slot name="appendSlot">
                                <div class="input-group-text bg-gradient-danger">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                    </div>
                    <div class="col-md-2">
                        <x-adminlte-button label="Cari" onclick="reload()" theme="info" />
                    </div>
                </div>
                @foreach($poli as $item)
                    <div class="row align-items-center">
                        <x-adminlte-input value="{{$item->nm_poli}}" id="poli" name="poli[]" label="Nama Poli" type="text" fgroup-class="col-md-8" disable-feedback/>
                        <x-adminlte-input value="{{$item->jml}}" id="jumlah" name="jumlah[]" label="Jumlah" type="number" fgroup-class="col-md-3" disable-feedback/>
                        <div class="col-md-1 mt-3">
                            <x-adminlte-button icon="fas fa-fw fa-trash" class="btn-sm deleteButton" theme="danger" />
                        </div>
                    </div>
                @endforeach
                <div class="d-flex flex-row-reverse">
                    <div class="p-2">
                        <x-adminlte-button label="Kirim" onclick="kirimDataPerawat()" theme="primary" />
                    </div>
                </div>
             </x-adminlte-card>
        </div>
        <div class="col-md-6">
            <x-adminlte-card title="Data Jumlah Pasien Rawat Jalan/Poli" theme="dark" theme-mode="outline">
                @php
                    $config = [
                        'order' => [[0, 'desc']],
                        "responsive" => true,
                    ];
                @endphp
                <x-adminlte-datatable id="tablePoli" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
                    @if(!empty($data['data']['datas']))
                        @foreach($data['data']['datas'] as $row)
                            <tr>
                                <td>{{ $row['tgl_transaksi'] }}</td>
                                <td>{{ $row['nama_poli'] }}</td>
                                <td>{{ $row['jumlah'] }}</td>
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

        $(".deleteButton").on("click", function(e){
            e.preventDefault();
            $(this).closest('.row').remove();
        });

        function getValue(name) {
            var data = [];
            var doc = document.getElementsByName(name);
            for (var i = 0; i < doc.length; i++) {
                    var a = doc[i].value;
                    data.push(a);
                }

            return data;
        }

        function reload(){
            let tgl = $("input[name=tanggal]").val();
            let url = "{{ url('/layanan/poli') }}";
            location.href = url + '?tgl=' + tgl;
        }

        function kirimDataPerawat() {
            let poli = getValue('poli[]');
            let jumlah = getValue('jumlah[]');
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                nama_poli:poli,
                jumlah:jumlah,
            };
            console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/poli/kirim',
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
                    // console.log(response);
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
                    // console.log(error);
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