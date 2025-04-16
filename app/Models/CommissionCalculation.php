<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionCalculation extends Model
{
    use HasFactory;

    protected $table = 'commission_calculations';

    protected $fillable = [
        'admin_id',
        'waybill_id',
        'airline_settlement_rate',
        'marketer_settlement_rate',
        'income_from_waybill',
        'commission_amount',
    ];

    public function waybill()
    {
        return $this->belongsTo(Waybill::class, 'waybill_id');
    }

}
