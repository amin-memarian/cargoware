<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaybillCustomsFee extends Model
{
    use HasFactory;

    protected $table = 'waybill_customs_fees';

    protected $fillable = [
        'admin_id',
        'user_id',
        'waybill_id',
        'price_detail',
    ];

    protected $casts = [
        'price_detail' => 'array'
    ];

    public function waybill()
    {
        return $this->belongsTo(Waybill::class, 'waybill_id');
    }

    public function getUserInformationAttribute()
    {
        return $this?->waybill?->user?->name . ' ' . $this?->waybill?->user?->lastname;
    }
}
