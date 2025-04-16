<?php

namespace App\Models;

use App\Interfaces\Model\MediaFiles\MediaFileInterface;
use App\Interfaces\Traits\HasTypeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model implements MediaFileInterface
{
    use HasFactory;

    protected $fillable = [
        self::NAME,
        self::PATH,
        self::TYPE,
        self::SIZE,
        self::RELATED_TYPE,
        self::RELATED_ID,
    ];

    public function related(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

}
