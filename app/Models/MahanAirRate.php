<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahanAirRate extends Model
{
    use HasFactory;

    protected $table = 'mahan_air_rates';

    protected $fillable = [
        'destination',
        'minimum',
        'normal',
        '45',
        '100',
        '250',
        '500',
        '1000',
        'upload_at',
    ];
}
