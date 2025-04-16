<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleComission extends Model
{
    use HasFactory;

    protected $table = 'sale_comissions';

    protected $fillable = [
        'airline_id',
        'm',
        'n',
        'c_45',
        'c_100',
        'c_300',
        'c_500',
        'c_1000',
        'created_at',
        'updated_at',
    ];

    public function airline(){
        return $this->belongsTo(Airline::class);
    }
}
