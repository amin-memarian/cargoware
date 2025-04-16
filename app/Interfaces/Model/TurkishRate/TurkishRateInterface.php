<?php

namespace App\Interfaces\Model\TurkishRate;

use App\Interfaces\Traits\HasDestinationInterface;
use App\Interfaces\Traits\HasFiveHundredInterface;
use App\Interfaces\Traits\HasFortyFiveInterface;
use App\Interfaces\Traits\HasHundredInterface;
use App\Interfaces\Traits\HasMinimumInterface;
use App\Interfaces\Traits\HasNormalInterface;
use App\Interfaces\Traits\HasThousandInterface;
use App\Interfaces\Traits\HasThreeHundredInterface;

interface TurkishRateInterface extends HasDestinationInterface, HasMinimumInterface, HasNormalInterface,
    HasFortyFiveInterface, HasHundredInterface, HasThreeHundredInterface, HasFiveHundredInterface, HasThousandInterface
{
    const TABLE = 'turkish_rates';
}
