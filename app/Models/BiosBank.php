<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiosBank extends Model
{
    use HasFactory;
    protected $table = 'bios_bank';
    protected $primaryKey = 'kode';
}
