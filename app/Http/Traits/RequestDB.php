<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

trait RequestDB {
    use Telegram;

    public function anggota($bidang)
    {
        $data = DB::table('pegawai')
                    ->where('bidang', $bidang)
                    ->where('stts_kerja', 'POL')
                    ->where('stts_aktif', '<>', 'KELUAR')
                    ->count('*');
        return $data;
    }

    public function pns($bidang)
    {
        $data = DB::table('pegawai')
                    ->where('bidang', $bidang)
                    ->where('stts_kerja', 'PNS')
                    ->where('stts_aktif', '<>', 'KELUAR')
                    ->count('*');
        return $data;
    }

    public function p3k($bidang)
    {
        $data = DB::table('pegawai')
                    ->where('bidang', $bidang)
                    ->where('stts_kerja', 'P3K')
                    ->where('stts_aktif', '<>', 'KELUAR')
                    ->count('*');
        return $data;
    }

    public function nonPNS($bidang)
    {
        $data = DB::table('pegawai')
                    ->where('bidang', $bidang)
                    ->where(function($query) {
                        $query->orWhere('stts_kerja', 'NPN')
                              ->orWhere('stts_kerja', 'PT');
                    })
                    ->where('stts_aktif', '<>', 'KELUAR')
                    ->count('*');
        return $data;
    }

    public function kontrak($bidang)
    {
        $data = DB::table('pegawai')
                    ->where('bidang', $bidang)
                    ->where('stts_kerja', 'KB')
                    ->where('stts_aktif', '<>', 'KELUAR')
                    ->count('*');
        return $data;
    }

    public function getRekening()
    {
        $data = DB::table('rekening_rumkit')
                    ->get();
        return $data;
    }

    public function countFarmasi($tanggal)
    {
       $data = DB::table('resep_obat')
                    ->where('tgl_peresepan', $tanggal)
                    ->count();
        return $data;
    }

    public function countIGD($tanggal)
    {
       $data = DB::table('reg_periksa')
                    ->where('tgl_registrasi', $tanggal)
                    ->where('kd_poli', 'IGDK')
                    ->distinct()
                    ->count();
        return $data;
    }

    public function getLab($tanggal)
    {
        $data = DB::table('periksa_lab')
                    ->where('tgl_periksa', $tanggal)
                    ->count();
        return $data;
    }

    public function countLab($tanggal)
    {
        $data = DB::table('periksa_lab')
                    ->join('jns_perawatan_lab', 'periksa_lab.kd_jenis_prw', '=', 'jns_perawatan_lab.kd_jenis_prw')
                    ->where('periksa_lab.tgl_periksa', $tanggal)
                    ->groupBy('jns_perawatan_lab.kd_jenis_prw')
                    ->selectRaw("jns_perawatan_lab.kd_jenis_prw, jns_perawatan_lab.nm_perawatan, count(periksa_lab.kd_jenis_prw) as jml")
                    ->get();
        return $data;
    }

    public function nmPerawatanLab($kd_jenis_prw)
    {
        $data = DB::table('jns_perawatan_lab')
                    ->where('kd_jenis_prw', $kd_jenis_prw)
                    ->first();
        return $data->nm_perawatan;
    }

    public function countOperasi($tanggal)
    {
        $data = DB::table('operasi')
                    ->where('tgl_operasi', 'like', $tanggal.'%')
                    ->groupBy('kategori')
                    ->selectRaw("kategori, count(no_rawat) as jml")
                    ->get();
        return $data;
    }

    public function countPoli($tanggal)
    {
        $data = DB::table('reg_periksa')
                    ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
                    ->where('tgl_registrasi', $tanggal)
                    ->where('stts', 'Sudah')
                    ->where('poliklinik.nm_poli', 'like', 'KLINIK%')
                    ->groupBy('poliklinik.nm_poli')
                    ->selectRaw("poliklinik.nm_poli, count(reg_periksa.no_rawat) as jml")
                    ->get();
        return $data;
    }

    public function countRadiologi($tanggal)
    {
        $data = DB::table('periksa_radiologi')
                    ->where('tgl_periksa', $tanggal)
                    ->count();
        return $data;
    }

    public function countRalan($tanggal)
    {
       $data = DB::table('reg_periksa')
                    ->where('tgl_registrasi', $tanggal)
                    ->where('stts', 'Sudah')
                    ->count();
        return $data;
    }

    public function countBPJS($tanggal)
    {
       $data = DB::table('reg_periksa')
                    ->where('tgl_registrasi', $tanggal)
                    ->where('stts', '<>', 'Batal')
                    ->where(function($query){
                        $query->orWhere('kd_pj', 'BPJ')
                             ->orWhere('kd_pj', 'BTK');
                    })
                    ->where('kd_pj', 'BPJ')
                    ->count();
        return $data;
    }

    public function countNonBPJS($tanggal)
    {
       $data = DB::table('reg_periksa')
                    ->where('tgl_registrasi', $tanggal)
                    ->where('stts', '<>', 'Batal')
                    ->where(function($query){
                        $query->orWhere('kd_pj', '<>', 'BPJ')
                             ->orWhere('kd_pj', '<>', 'BTK');
                    })
                    ->count();
        return $data;
    }

    public function counRanap($tanggal)
    {
        return DB::table('kamar')
                    ->join('kamar_inap', 'kamar_inap.kd_kamar', '=', 'kamar.kd_kamar')
                    ->where('kamar_inap.tgl_masuk', $tanggal)
                    ->where('kamar_inap.tgl_keluar', '0000-00-00')
                    ->groupBy('kamar.kelas')
                    ->select(DB::raw('TRIM("Kelas" FROM kamar.kelas) AS kelas'), DB::raw('count(kamar_inap.no_rawat) as jml'))
                    ->get();
    }

    public function countBOR()
    {
        $first = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $last = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $hari = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->format('d');
        try{

            $lamaInap = DB::table('kamar_inap')
                    ->whereBetween('tgl_masuk', [$first, $last])
                    ->sum('lama');
            $jmlKamar = DB::table('kamar')
                        ->where('statusdata', '1')
                        ->count();
            $bor = ($lamaInap / ($jmlKamar*$hari)) * 100;
            $this->sendMessage(' '.$first.' '.$last.' '.$hari);
        }catch(\Exception $e){
            $this->sendMessage('Simpan Log Bor gagal : '.$e->getMessage() ?? '');
            $bor = 0;
        }
        
        return round($bor);
    }

    public function countALOS()
    {
        $first = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $last = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        try{

            $lamaInap = DB::table('kamar_inap')
                    ->whereBetween('tgl_masuk', [$first, $last])
                    ->sum('lama');
            $jmlRawat = DB::table('kamar_inap')
                        ->whereBetween('tgl_keluar', [$first, $last])
                        ->count();
            $alos = $lamaInap / $jmlRawat;
            $this->sendMessage(' '.$first.' '.$last);
        }catch(\Exception $e){
            $this->sendMessage('Simpan Log Alos gagal : '.$e->getMessage() ?? '');
            $alos = 0;
        }
        
        return round($alos);
    }

    public function countTOI()
    {
        $first = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $last = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $hari = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->format('d');

        try{

            $lamaInap = DB::table('kamar_inap')
                        ->whereBetween('tgl_masuk', [$first, $last])
                        ->sum('lama');
            $jmlKamar = DB::table('kamar')
                        ->where('statusdata', '1')
                        ->count();
            $jmlRawat = DB::table('kamar_inap')
                        ->whereBetween('tgl_keluar', [$first, $last])
                        ->count();

            $toi = (($jmlKamar*$hari)-$lamaInap)/$jmlRawat;
            $this->sendMessage($toi.' '.$first.' '.$last.' '.$hari);

        }catch(\Exception $e){
            $this->sendMessage('Simpan Log Toi gagal : '.$e->getMessage() ?? '');
            $toi = 0;
        }
        return round($toi);
    }

    public function countBTO()
    {
        $first = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $last = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $hari = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->format('d');

        try{

            $jmlKamar = DB::table('kamar')
                        ->where('statusdata', '1')
                        ->count();

            $jmlRawat = DB::table('kamar_inap')
                        ->whereBetween('tgl_keluar', [$first, $last])
                        ->count();

            $bto = $jmlRawat/$jmlKamar;
            $this->sendMessage($bto.' '.$first.' '.$last.' '.$hari);

        }catch(\Exception $e){
            $this->sendMessage('Simpan Log Bto gagal : '.$e->getMessage() ?? '');
            $bto = 0;
        }

        return round($bto);
    }

    public function taskSetting($layanan)
    {
        $data = DB::table('bios_task_setting')
                    ->where('task_name', $layanan)
                    ->first();
        return $data;
    }

    public function simpanLog($table, array $data)
    {
        try{
            if($table == 'bios_log')
            DB::table($table)->insert($data);

        }catch(\Exception $e){

            $this->sendMessage('Simpan Log '.$table.' gagal : '.$e->getMessage());

        }
    }

    public function bacaLog($table)
    {
        $data = DB::table($table)
                    ->orderBy('tgl_transaksi', 'desc')
                    ->get();
        return $data;
    }
}