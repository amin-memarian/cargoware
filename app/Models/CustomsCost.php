<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomsCost extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'user_id', 'load_detail_id', 'price_detail'];

    protected $casts = [
        'price_detail' => 'array'
    ];

}
