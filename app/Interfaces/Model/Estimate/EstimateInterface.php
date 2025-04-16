<?php

namespace App\Interfaces\Model\Estimate;

use App\Interfaces\Traits\HasAdminEstimateInterface;
use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasAirlineIdInterface;
use App\Interfaces\Traits\HasIdInterface;
use App\Interfaces\Traits\HasLoadIdInterface;
use App\Interfaces\Traits\HasEstimateInterface;
use App\Interfaces\Traits\HasRejectionReasonInterface;
use App\Interfaces\Traits\HasROEInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasUserIdInterface;

interface EstimateInterface extends HasUserIdInterface, HasLoadIdInterface, HasAirlineIdInterface, HasROEInterface, HasEstimateInterface,
    HasAdminIdInterface, HasIdInterface, HasAdminEstimateInterface, HasRejectionReasonInterface, HasStatusInterface
{
    const TABLE = 'estimates';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function airline(): \Illuminate\Database\Eloquent\Relations\HasOne;

}
