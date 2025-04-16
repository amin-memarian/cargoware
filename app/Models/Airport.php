<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    protected $table = 'airports';

    protected $fillable = [
        'fa_name',
        'en_name',
        'iata_code',
        'en_country',
        'fa_country',
        'created_at',
        'updated_at',
    ];
}
