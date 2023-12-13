<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kelolaan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_kelolaan';
    protected $fillable = ['tgl_transaksi', 'kdbank', 'no_rekening', 'saldo_akhir', 'kode', 'status', 'response'];

    public function bank()
    {
        return $this->belongsTo(BiosBank::class, 'kdbank', 'kode');
    }

    public function rekening()
    {
        return $this->belongsTo(BiosRekening::class, 'no_rekening', 'no_rek');
    }
}
