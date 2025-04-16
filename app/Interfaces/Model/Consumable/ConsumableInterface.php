<?php

namespace App\Interfaces\Model\Consumable;

use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasCostInterface;
use App\Interfaces\Traits\HasNameInterface;
use App\Interfaces\Traits\HasQuantityInterface;
use App\Interfaces\Traits\HasRelatedIdInterface;
use App\Interfaces\Traits\HasRelatedTypeInterface;

interface ConsumableInterface extends HasAdminIdInterface, HasNameInterface, HasCostInterface, HasQuantityInterface, HasRelatedIdInterface, HasRelatedTypeInterface
{
    const TABLE = 'consumables';

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne;

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function getAdminInformationAttribute(): string;

}
