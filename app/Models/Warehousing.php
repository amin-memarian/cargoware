<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehousing extends Model
{
    use HasFactory;

    protected $table = 'warehousing';

    protected $fillable = [
        'manager_id',
        'name',
        'price_rate',
        'has_image',
        'is_unit',
        'is_main',
        'address'
    ];

    protected $attributes = [
        'is_unit' => '1',
        'is_main' => '1',
    ];

    public function mediaFiles(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(MediaFile::class, 'related');
    }

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(MediaFile::class, 'related');
    }

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function getIsUnitTextAttribute(): string
    {
        return $this->is_unit == '1' ? 'واحد است' : 'واحد نیست';
    }

    public function getIsMainTextAttribute(): string
    {
        return $this->is_main == '1' ? 'اصلی است' : 'اصلی نیست';
    }

    public function getPriceRateNumberFormatAttribute(): string
    {
        return number_format($this->attributes['price_rate']);
    }

    public function getManagerInformationAttribute(): string
    {
        return ($this->manager?->lastname || $this->manager?->mobile) ? $this->manager?->lastname . ' ' . $this->manager?->mobile : '-';
    }

    public function setPriceRateAttribute($value): void
    {
        $this->attributes['price_rate'] = str_replace(',', '', $value);
    }

}
