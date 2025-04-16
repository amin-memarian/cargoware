<?php

namespace App\Models;

use App\Interfaces\Model\Estimate\EstimateInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estimate extends Model implements EstimateInterface
{
    use HasFactory, SoftDeletes;

    //TODO: need to check
    protected $with = ['airline', 'user'];

    protected $fillable = [
        self::ADMIN_ID,
        self::USER_ID,
        self::LOAD_ID,
        self::AIRLINE_ID,
        self::ROE,
        self::ESTIMATE,
        self::REJECTION_REASON,
        self::ADMIN_ESTIMATE,
        self::STATUS,
        'publish_status'
    ];

    protected $attributes = [
        self::STATUS => '0',
        'publish_status' => '0'
    ];

    public function loads(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
       return $this->belongsTo(Load::class, 'load_id');
    }

    public function loadDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(LoadDetail::class, 'estimate_id');
    }

    public function loadDetails(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(LoadDetail::class, 'estimate_id');
    }



    public function airline(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Airline::class, self::ID, self::AIRLINE_ID);
    }

    public function airlines(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Airline::class, self::AIRLINE_ID);
    }

    public function getAirlineImagePathAttribute()
    {
        return $this->airlines?->mediaFile?->path ?: '';
    }

    public function getLoadDestinationAttribute()
    {
        return $this?->loads?->address ?: '-';
    }

    public function getLoadOriginAttribute()
    {
        return $this?->loads?->store ?: '-';
    }

    public function getUserInformationAttribute()
    {
        return ($this->user?->lastname || $this->user?->mobile) ? $this->user?->lastname . ' ' . $this->user?->mobile : '-';
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, self::USER_ID);
    }

}
