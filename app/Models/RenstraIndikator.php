<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenstraIndikator extends Model
{
    use HasFactory;
    protected $table = 'renstra_indikator';
    protected $fillable = ['indikator', 'status'];
}
