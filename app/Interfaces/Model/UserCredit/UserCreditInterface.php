<?php

namespace App\Interfaces\Model\UserCredit;

use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasExpireTimeInterface;
use App\Interfaces\Traits\HasGuaranteeFileInterface;
use App\Interfaces\Traits\HasQuantityInterface;
use App\Interfaces\Traits\HasGuarantorNameInterface;
use App\Interfaces\Traits\HasGuarantorUserIdInterface;
use App\Interfaces\Traits\HasRelatedIdInterface;
use App\Interfaces\Traits\HasRelatedTypeInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasUserIdInterface;

interface UserCreditInterface extends HasUserIdInterface, HasQuantityInterface, HasExpireTimeInterface,
    HasGuarantorUserIdInterface, HasGuarantorNameInterface, HasGuaranteeFileInterface, HasStatusInterface, HasAdminIdInterface
    ,HasRelatedTypeInterface, HasRelatedIdInterface
{
    const TABLE = 'user_credits';

    public function mediaFile(): \Illuminate\Database\Eloquent\Relations\MorphOne;

    public function mediaFiles(): \Illuminate\Database\Eloquent\Relations\MorphMany;

    public function guarantor(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

}
