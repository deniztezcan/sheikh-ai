<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ayah extends Model
{
    use HasFactory;

    public $fillable = [
        'surah_id',
        'number',
        'content',
        'embedding',
    ];
}
