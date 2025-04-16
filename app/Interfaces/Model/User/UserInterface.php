<?php

namespace App\Interfaces\Model\User;

use App\Interfaces\Traits\HasIdInterface;
use App\Interfaces\Traits\HasIsPartnerInterface;
use App\Interfaces\Traits\HasLastNameInterface;
use App\Interfaces\Traits\HasMobileInterface;
use App\Interfaces\Traits\HasNameInterface;

interface UserInterface extends HasIdInterface, HasNameInterface, HasLastNameInterface, HasMobileInterface, HasIsPartnerInterface
{
    const Table = 'Users';
}
