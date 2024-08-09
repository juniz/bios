<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Penerimaan extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_penerimaan';
    protected $fillable = ['tgl_transaksi', 'kode_akun', 'jumlah', 'kode', 'status', 'response'];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'kode_akun', 'kode');
    }
}
