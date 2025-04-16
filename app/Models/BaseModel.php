<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    //TODO: maybe need
//    public static function getTableColumns(): array
//    {
//        return Schema::getColumnListing((new static)->getTable());
//    }
//
//    public function hasField($field): bool
//    {
//        return in_array($field, self::getTableColumns());
//    }

}
