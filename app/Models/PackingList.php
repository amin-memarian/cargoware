<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackingList extends Model
{
    protected $table = 'packing_lists';

    protected $fillable = [
        'fa_name',
        'en_name',
        'packages',
        'load_id',
        'net_weight',
        'gross_weight',
        'hs_code',
        'status',
        'remark',
    ];

    protected $casts = [
        'packages' => 'array'
    ];

}
