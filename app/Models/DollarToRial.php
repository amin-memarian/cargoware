<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DollarToRial extends Model
{
    use HasFactory;

    protected $table = 'dollar_to_rials';

    protected $fillable = [
        'value',
        'created_at',
        'updated_at',
    ];
}
