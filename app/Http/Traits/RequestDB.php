<?php

namespace App\Http\Traits;
use DB;

trait RequestDB {

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
                    ->where('stts_kerja', 'NPN')
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
}