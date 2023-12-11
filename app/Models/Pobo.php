<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Pobo extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_pobo';
    protected $fillable = ['tgl_transaksi', 'pobo', 'kode', 'status', 'response'];
}
