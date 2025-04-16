<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distance extends Model
{
    use HasFactory;

    protected $table = 'distances';

    protected $fillable = [
        'name',
        'iso_code',
        'distance',
        'created_at',
        'updated_at',
    ];
}
