<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IranAirRate extends Model
{
    use HasFactory;

    protected $table = 'iran_air_rates';

    protected $fillable = [
        'destination',
        'minimum',
        'normal',
        '45',
        '100',
        '300',
        '500',
        '1000',
        'upload_at',
    ];
}
