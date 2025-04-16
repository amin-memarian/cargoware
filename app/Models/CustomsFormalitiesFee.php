<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomsFormalitiesFee extends Model
{
    use HasFactory;

    protected $table = 'customs_formalities_fees';

    protected $fillable = [
        'from_weight',
        'to_weight',
        'price',
    ];


}
