<?php

namespace App\Interfaces\Model\SalesTeam;

use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasManagerIdInterface;
use App\Interfaces\Traits\HasSalesStaffInterface;
use App\Interfaces\Traits\HasTeamNameInterface;

interface SalesTeamInterface extends HasAdminIdInterface, HasTeamNameInterface, HasManagerIdInterface, HasSalesStaffInterface
{
    const Table = 'sales_team';
}
