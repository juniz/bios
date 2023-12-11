<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Visite3 extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_visite_3';
    protected $fillable = ['tgl_transaksi', 'jumlah', 'kode', 'status', 'response'];
}
