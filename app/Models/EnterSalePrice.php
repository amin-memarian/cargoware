<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnterSalePrice extends Model
{
    use HasFactory;

    protected $table = 'enter_sale_prices';

    protected $fillable = [
        'admin_id',
        'consumable_id',
        'partner_profit_percentage',
        'customer_profit_percentage',
        'partner_price',
        'customer_price'
    ];

    public function consumable(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Consumable::class, 'id', 'consumable_id');
    }

    public function getConsumableNameAttribute()
    {
        return $this?->consumable ? $this?->consumable?->name : '-';
    }

}
