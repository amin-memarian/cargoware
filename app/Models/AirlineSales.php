<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirlineSales extends Model
{
    use HasFactory;

    protected $table = 'airline_sales';

    protected $fillable = [
        'airline_id',
        'waybill_no',
        'from',
        'to',
        'gross_weight',
        'chargeable_weight',
        'rate',
        'air_freight',
        'variables',
        'other_charges',
        'tax',
        'total',
        'remark',
    ];

    protected $casts = [
        'variables' => 'array'
    ];



}
