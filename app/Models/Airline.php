<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    use HasFactory;

    protected $table = 'airlines';

    protected $fillable = [
        'name',
        'logo',
        'tariff',
        'ROE',
        'Sale_rate',
        'AWB',
        'AWA',
        'AWC',
        'SCC',
        'SCC_min',
        'TVC',
        'HXC',
        'ATA',
        'ATA_min',
        'ATA_max',
        'TDC',
        'CGC',
        'MCC',
        'INC',
        'MMA',
        'MYC',
        'FEC',
        'XDC',
        'bfc',
        'mac',
        'related_type',
        'related_id',
        'created_at',
        'updated_at'
    ];

    public function mediaFiles(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(MediaFile::class, 'related');
    }

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(MediaFile::class, 'related');
    }

    public function sale_comission_rates()
    {
        return $this->hasOne(SaleComission::class,'airline_id','id');
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class,'airline_id','id');
    }

    protected $with = ['sale_comission_rates'];

    public static array $airlineTranslations = [
        'Iran Air' => 'ایران ایر',
        'Qeshm Air' => 'قشم',
        'Mahan Air' => 'ماهان ایر',
        'Emirates' => 'امارات',
        'Qatar' => 'قطر',
        'Fly Dubai' => 'فلای دبی',
        'Air Arabia' => 'ایر اربیا',
        'Varesh' => 'وارش',
        'Turkish' => 'ترکیش',
        'Aeroflot' => 'ایر فلوت'
    ];

}
