<?php

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;

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
}