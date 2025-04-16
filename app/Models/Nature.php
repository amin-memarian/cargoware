<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nature extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'code', 'en_name'];
}
