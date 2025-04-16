<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QatarRate extends Model
{
    use HasFactory;

    protected $table = 'qatar_rates';

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
