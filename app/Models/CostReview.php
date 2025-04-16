<?php

namespace App\Models;

use App\Interfaces\Model\CostReview\CostReviewInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostReview extends Model implements CostReviewInterface
{
    use HasFactory;

    protected $table = self::TABLE;

    protected $fillable = [
        self::ADMIN_ID,
        self::USER_ID,
        self::ORIGIN,
        self::DESTINATION,
        self::WEIGHT,
        self::VOLUME_WEIGHT,
        self::TEXT,
        self::ANSWER,
        self::IS_BROKER,
        self::BROKER_ID,
        self::STATUS,
    ];

    protected $attributes = [
        self::STATUS => '0',
        self::ANSWER => null,
        self::BROKER_ID => null
    ];

}
