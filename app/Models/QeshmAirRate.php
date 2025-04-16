<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QeshmAirRate extends Model
{
    use HasFactory;

    protected $table = 'qeshm_air_rates';

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
