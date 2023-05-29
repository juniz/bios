@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Jumlah Layanan Dokpol</h1>
@stop

@section('content')
<x-adminlte-card title="Input Jumlah Layanan Dokpol" theme="dark" theme-mode="outline">
    <div class="row">
        <x-adminlte-input id="kedokteran_forensik" name="kedokteran_forensik" label="Kedokteran Forensik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="psikiatri_forensik" name="psikiatri_forensik" label="Psikiatri Forensik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="sentra_visum_dan_medikolegal" name="sentra_visum_dan_medikolegal" label="Sentra Visum dan Medikolegal" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="ppat" name="ppat" label="PPAT" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
    </div>
    <div class="row">
        <x-adminlte-input id="odontologi_forensik" name="odontologi_forensik" label="Odontologi Forensik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="psikologi_forensik" name="psikologi_forensik" label="Psikologi Forensik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="antropologi_forensik" name="antropologi_forensik" label="Antropologi Forensik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="olah_tkp_medis" name="olah_tkp_medis" label="Olah TKP Medis" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
    </div>
    <div class="row">
        <x-adminlte-input id="kesehatan_tahanan" name="kesehatan_tahanan" label="Kesehatan Tahanan" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="narkoba" name="narkoba" label="Narkoba" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="toksikologi_medik" name="toksikologi_medik" label="Toksikologi Medik" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="pelayanan_dna" name="pelayanan_dna" label="Pelayanan DNA" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
    </div>
    <div class="row">
        <x-adminlte-input id="pam_keslap_food_security" name="pam_keslap_food_security" label="PAM Keslap Food Security" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
        <x-adminlte-input id="dvi" name="dvi" label="DVI" type="number" value="0" fgroup-class="col-md-3" disable-feedback/>
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


<x-adminlte-card title="Data Jumlah Layanan Dokpol" theme="dark" theme-mode="outline">
    @php
        $config = [
            'order' => [[0, 'desc']],
            "responsive" => true,
        ];
    @endphp
    <x-adminlte-datatable id="tableDokpol" :heads="$head" head-theme="dark" :config="$config" striped hoverable bordered compressed>
        @forelse($data as $data)
            <tr @if($data->response == 'MSG20003') class="bg-success" @endif>
                <td>{{ $data->tgl_transaksi }}</td>
                <td>{{ $data->kedokteran_forensik }}</td>
                <td>{{ $data->psikiatri_forensik }}</td>
                <td>{{ $data->sentra_visum_dan_medikolegal }}</td>
                <td>{{ $data->ppat }}</td>
                <td>{{ $data->odontologi_forensik }}</td>
                <td>{{ $data->psikologi_forensik }}</td>
                <td>{{ $data->antropologi_forensik }}</td>
                <td>{{ $data->olah_tkp_medis }}</td>
                <td>{{ $data->kesehatan_tahanan }}</td>
                <td>{{ $data->narkoba }}</td>
                <td>{{ $data->toksikologi_medik }}</td>
                <td>{{ $data->pelayanan_dna }}</td>
                <td>{{ $data->pam_keslap_food_security }}</td>
                <td>{{ $data->dvi }}</td>
                <td>{{ $data->send_at }}</td>
                <td>{{ $data->updated_at }}</td>
                <td>
                    <x-adminlte-button 
                        label="Kirim Ulang" 
                        onclick="kirimUlang(
                            '{{$data->tgl_transaksi}}',
                            '{{$data->kedokteran_forensik}}',
                            '{{$data->psikiatri_forensik}}',
                            '{{$data->sentra_visum_dan_medikolegal}}',
                            '{{$data->ppat}}',
                            '{{$data->odontologi_forensik}}',
                            '{{$data->psikologi_forensik}}',
                            '{{$data->antropologi_forensik}}',
                            '{{$data->olah_tkp_medis}}',
                            '{{$data->kesehatan_tahanan}}',
                            '{{$data->narkoba}}',
                            '{{$data->toksikologi_medik}}',
                            '{{$data->pelayanan_dna}}',
                            '{{$data->pam_keslap_food_security}}',
                            '{{$data->dvi}}',
                            )" 
                        class="btn-sm" 
                        icon="fas fa-lg fa-save"  
                    />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="18" class="text-center">Tidak Ada Data</td>
            </tr>
        @endforelse
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
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        function kirimDataPerawat() {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:$("input[name=tanggal]").val(),
                kedokteran_forensik:$("input[name=kedokteran_forensik]").val(),
                psikiatri_forensik:$("input[name=psikiatri_forensik]").val(),
                sentra_visum_dan_medikolegal:$("input[name=sentra_visum_dan_medikolegal]").val(),
                ppat:$("input[name=ppat]").val(),
                odontologi_forensik:$("input[name=odontologi_forensik]").val(),
                psikologi_forensik:$("input[name=psikologi_forensik]").val(),
                antropologi_forensik:$("input[name=antropologi_forensik]").val(),
                olah_tkp_medis:$("input[name=olah_tkp_medis]").val(),
                kesehatan_tahanan:$("input[name=kesehatan_tahanan]").val(),
                narkoba:$("input[name=narkoba]").val(),
                toksikologi_medik:$("input[name=toksikologi_medik]").val(),
                pelayanan_dna:$("input[name=pelayanan_dna]").val(),
                pam_keslap_food_security:$("input[name=pam_keslap_food_security]").val(),
                dvi:$("input[name=dvi]").val(),
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/dokpol/kirim',
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
                        text: JSON.stringify(response.error, null, 4),
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

        function kirimUlang(tgl,kedokteran,psikiatri,sentra,ppat,odontologi,psikologi,antropologi,olah_tkp,kesehatan,narkoba,toksikologi,pelayanan,pam,dvi) {
            let data = {
                _token:$('meta[name="csrf-token"]').attr('content'),
                tgl_transaksi:tgl,
                kedokteran_forensik:kedokteran,
                psikiatri_forensik:psikiatri,
                sentra_visum_dan_medikolegal:sentra,
                ppat:ppat,
                odontologi_forensik:odontologi,
                psikologi_forensik:psikologi,
                antropologi_forensik:antropologi,
                olah_tkp_medis:olah_tkp,
                kesehatan_tahanan:kesehatan,
                narkoba:narkoba,
                toksikologi_medik:toksikologi,
                pelayanan_dna:pelayanan,
                pam_keslap_food_security:pam,
                dvi:dvi,
            };
            // console.log(data);
            $.ajax({
                type:'POST',
                url:'/layanan/dokpol/kirim',
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
                        text: JSON.stringify(response.error, null, 4),
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