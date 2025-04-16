<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Interfaces\Model\User\UserInterface;
use App\Interfaces\Traits\HasIdInteface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements UserInterface, LaratrustUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions;

    protected $fillable = [
        'name',
        'lastname',
        'mobile',
        'is_partner',
        'role',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function partner()
    {
        return $this->hasMany(Partner::class, 'user_id', 'id');
    }

    public function estimate()
    {
        return $this->belongsTo(Estimate::class,'user_id','id');
    }

    protected $with = ['partner'];

    public static function allUsers()
    {
        return self::query()->where('id', '>', 1)
            ->orderByDesc('id')
            ->get();
    }

    public static function getPartners()
    {
        return self::query()->where('id', '>', 1)
            ->where('is_partner', 1)
            ->orderByDesc('id')->get();
    }

    public static function searchPartners($word)
    {
        return self::query()->where(self::ID, '>', 1)
            ->where(self::IS_PARTNER, 1)
            ->where(self::NAME,'like','%'.$word.'%')
            ->orWhere(self::MOBILE,'like','%'.$word.'%')->get();
    }

    public static function searchUser($word)
    {
        return self::query()
            ->where(self::ID, '>', 1)
            ->where(self::IS_PARTNER, 1)
            ->where(function ($query) use ($word) {

                $words = explode(' ', $word);
                foreach ($words as $wordPart) {
                    $query->where(function ($subQuery) use ($wordPart) {
                        $subQuery->where(self::NAME, 'like', '%' . $wordPart . '%')
                            ->orWhere(self::LAST_NAME, 'like', '%' . $wordPart . '%')
                            ->orWhere(self::MOBILE, 'like', '%' . $wordPart . '%');
                    });
                }
            })
            ->get();
    }

    public static function searchAllUsers($word)
    {
        return self::query()
            ->where(self::ID, '>', 1)
            ->where(function ($query) use ($word) {

                $words = explode(' ', $word);
                foreach ($words as $wordPart) {
                    $query->where(function ($subQuery) use ($wordPart) {
                        $subQuery->where(self::NAME, 'like', '%' . $wordPart . '%')
                            ->orWhere(self::LAST_NAME, 'like', '%' . $wordPart . '%');
                    });
                }
            })
            ->get();
    }

    public function userCredit()
    {
        return $this->hasMany(UserCredit::class, 'user_id');
    }

    public function getCreditQuantityAttribute()
    {
        return $this->userCredit()->sum('quantity');
    }

    public function getInformationAttribute()
    {
        return ($this?->lastname || $this?->mobile) ? $this?->lastname . ' ' . $this?->mobile : '-';
    }

}
