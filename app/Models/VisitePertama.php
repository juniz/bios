<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class VisitePertama extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'bios_visite_pertama';
    protected $fillable = ['tgl_transaksi', 'jumlah', 'kode', 'status', 'response'];
}
