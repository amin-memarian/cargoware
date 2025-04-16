<?php

namespace App\Models;

use App\Interfaces\Model\TurkishRate\TurkishRateInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurkishRate extends Model implements TurkishRateInterface
{
    use HasFactory;

     protected $table = self::TABLE;

    protected $fillable = [
        self::DESTINATION,
        self::MINIMUM,
        self::NORMAL,
        self::FORTY_FIVE,
        self::HUNDRED,
        self::THREE_HUNDRED,
        self::FIVE_HUNDRED,
        self::THOUSAND,
    ];

}
