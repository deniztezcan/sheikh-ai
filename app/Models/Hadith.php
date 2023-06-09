<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadith extends Model
{
    use HasFactory;

    public $fillable = [
        'collection',
        'volume',
        'book',
        'number',
        'content',
    ];
}
