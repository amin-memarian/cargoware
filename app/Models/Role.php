<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    public function permissions(): BelongsToMany
    {
        return parent::permissions();
    }

    public function givePermissions(iterable $permissions): static
    {
        return parent::givePermissions($permissions);
    }
}
