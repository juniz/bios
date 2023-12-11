<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Operasional extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_operasional';
    protected $fillable = ['tgl_transaksi', 'kdbank', 'no_rekening', 'unit', 'saldo_akhir', 'kode', 'status', 'response'];
}
