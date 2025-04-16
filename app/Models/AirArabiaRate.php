<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirArabiaRate extends Model
{
    use HasFactory;

    protected $table = 'air_arabia_rates';

    protected $fillable = [
        'destination',
        'minimum',
        'normal',
        '45',
        '100',
        '250',
        '500',
        '1000'
    ];

}
