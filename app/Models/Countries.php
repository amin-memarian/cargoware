<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'en_full_name',
        'fa_full_name',
        'en_iso_code',
        'en_title',
        'created_at',
        'updated_at',
    ];
}
