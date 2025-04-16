<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmiratesRate extends Model
{
    use HasFactory;

    protected $table = 'emirates_rates';

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
