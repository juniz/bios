<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasFactory;

    protected $table = 'rekening_rumkit';
    protected $fillable = ['no_rek', 'nama'];
    protected $primaryKey = 'no_rek';
    public $incrementing = false;
    public $timestamps = false;
}
