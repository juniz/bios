<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiosRekening extends Model
{
    use HasFactory;
    protected $table = 'rekening_rumkit';
    protected $primaryKey = 'no_rek';
    public $incrementing = false;
}
