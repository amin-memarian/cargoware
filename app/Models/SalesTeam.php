<?php

namespace App\Models;

use App\Interfaces\Model\SalesTeam\SalesTeamInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SalesTeam extends Model implements SalesTeamInterface
{
    use HasFactory, SoftDeletes;

    protected $table = self::Table;

    protected $fillable = [
        self::ADMIN_ID,
        self::TEAM_NAME,
        self::MANAGER_ID,
        self::SALES_STAFF,
    ];

    public function manager(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    protected function formattedSalesStaff(): Attribute
    {
        return Attribute::make(
            get: function () {
                $staffIds = json_decode($this->sales_staff, true);

                if (is_array($staffIds) && !empty($staffIds)) {
                    $staffList = User::query()->whereIn('id', $staffIds)->get();

                    return $staffList->map(function ($staff) {
                        return $staff->lastname . ' ' . $staff->mobile;
                    })->implode(' | ');
                }

                return 'کارکنان مشخص نیستند';
            }
        );
    }



}
