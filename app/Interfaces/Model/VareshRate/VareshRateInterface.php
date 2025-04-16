<?php

namespace App\Interfaces\Model\VareshRate;

use App\Interfaces\Traits\HasDestinationInterface;
use App\Interfaces\Traits\HasMinimumInterface;
use App\Interfaces\Traits\HasNormalInterface;

interface VareshRateInterface extends HasDestinationInterface, HasMinimumInterface, HasNormalInterface
{
    const TABLE = 'varesh_rates';
}
