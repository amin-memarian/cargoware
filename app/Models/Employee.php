<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable implements LaratrustUser
{
    use HasFactory, HasRolesAndPermissions;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'last_name',
        'mobile',
        'role_id',
        'unit_id',
        'has_image',
        'status'
    ];

    protected $attributes = [
        'status' => '1'
    ];

    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function mediaFiles(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(MediaFile::class, 'related');
    }

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(MediaFile::class, 'related');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function getFileNameAttribute()
    {
        return $this?->mediaFile ? $this->mediaFile?->name : null;
    }

    public function scopeWarehouseManagers($query)
    {
        return $query->whereHas('roles.permissions', function ($query) {

            $query->where('name', 'add warehouse')
                ->orWhere('name', 'delete warehouse');
        })->orderByDesc('id');
    }

    public function getInformationAttribute()
    {
        return ($this?->last_name || $this?->mobile) ? $this?->last_name . ' ' . $this?->mobile : '-';
    }

    public function collectionAgent(): HasOne
    {
        return $this->hasOne(CollectionAgent::class);
    }
}
