<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    use HasFactory;

    protected $table = 'waybills';

    protected $fillable = [
        'user_id',
        'load_id',
        'load_detail_id',
        'estimate_id',
        'airline_id',
        'airline_name',
        'airline_logo',
        'destination',
        'gross_weight',
        'chargeable_weight',
        'variables',
        'agent_variables',
        'carrier_variables',
        'sum_of_agent_variables',
        'sum_of_carrier_variables',
        'total_amount',
        'total_prepaid',
        'rate',
        'roe',
        'tax',
        'sender_name',
        'sender_address',
        'receiver_name',
        'receiver_address',
        'declared_value',
        'package_count',
        'publish_status'
    ];

    protected $casts = [
        'variables' => 'array',
        'agent_variables' => 'array',
        'carrier_variables' => 'array'
    ];

    protected $attributes = [
        'publish_status' => '0'
    ];

    public function loadDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LoadDetail::class, 'estimate_id', 'estimate_id');
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'estimate_id', 'id');
    }

    public function loads()
    {
        return $this->belongsTo(Load::class, 'load_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function waybillCustomsFee()
    {
        return $this->belongsTo(WaybillCustomsFee::class, 'id', 'waybill_id');
    }

    public function commissionCalculation()
    {
        return $this->belongsTo(CommissionCalculation::class, 'id', 'waybill_id');
    }

}
