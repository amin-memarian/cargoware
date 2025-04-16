<?php

namespace App\Models;

use App\Interfaces\Model\Consumable\ConsumableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumable extends Model implements ConsumableInterface
{
    use HasFactory;

    protected $fillable = [
        self::ADMIN_ID,
        self::NAME,
        self::QUANTITY,
        'unit_of_measurement',
        'is_for_pickup_agent',
        'packaging_in_warehouse',
        self::RELATED_ID,
        self::RELATED_TYPE,
    ];

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(MediaFile::class, 'related');
    }


    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, self::ADMIN_ID);
    }

    public function unitsConsumption()
    {
        return $this->belongsTo(UnitsConsumption::class, 'id', 'consumable_id');
    }

    public function getAdminInformationAttribute(): string
    {
        return ($this?->admin?->lastname || $this?->admin?->mobile) ? $this?->admin?->lastname . ' ' . $this?->admin?->mobile : '-';
    }




}
