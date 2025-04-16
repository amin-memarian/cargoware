<?php

namespace App\Interfaces\Model\CostReview;

use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasAnswerInterface;
use App\Interfaces\Traits\HasBrokerIdInterface;
use App\Interfaces\Traits\HasDestinationInterface;
use App\Interfaces\Traits\HasIsBrokerInterface;
use App\Interfaces\Traits\HasOriginInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasTextInterface;
use App\Interfaces\Traits\HasUserIdInterface;
use App\Interfaces\Traits\HasVolumeWeightInterface;
use App\Interfaces\Traits\HasWeightInterface;

interface CostReviewInterface extends HasOriginInterface, HasDestinationInterface, HasVolumeWeightInterface,
    HasAdminIdInterface, HasUserIdInterface, HasTextInterface, HasIsBrokerInterface,
    HasStatusInterface, HasWeightInterface, HasAnswerInterface, HasBrokerIdInterface
{
    const TABLE = 'cost_reviews';
}
