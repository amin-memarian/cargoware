<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory;

    protected $table = 'loads';

    protected $fillable = [
        'number',
        'user_id',
        'store',
        'address',
        'weight',
        'size_width',
        'size_height',
        'size_length',
        'pic',
        'count',
        'type',
        'volume_weight',
        'dimensions_detail'
    ];

    protected $casts = [
        'dimensions_detail' => 'array'
    ];
    public static array $types = [
        'GCR' => 'جنرال کارگو',
        'DG' => 'کالای خطرناک',
        'AVI' => 'حیوان زنده',
        'HUM' => 'جسد',
        'VAL' => 'کالای ارزشمند',
        'PER' => 'فاسد شدنی',
    ];

    public function country()
    {
        return $this->belongsTo(Countries::class, 'address', 'en_title');
    }

    public function getCountryNameAttribute()
    {
        return $this?->country ? $this?->country?->fa_full_name : '-';
    }

}
