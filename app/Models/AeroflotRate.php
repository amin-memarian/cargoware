<?php

namespace App\Models;

use App\Interfaces\Model\AeroflotRate\AeroflotRateInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AeroflotRate extends Model implements AeroflotRateInterface
{
    use HasFactory;

    protected $table = self::TABLE;

    protected $fillable = [
        self::DESTINATION,
        self::MINIMUM,
        self::NORMAL, // It's -45
        self::FORTY_FIVE,
        self::HUNDRED,
        self::THREE_HUNDRED,
        self::FIVE_HUNDRED,
        self::THOUSAND
    ];
}
