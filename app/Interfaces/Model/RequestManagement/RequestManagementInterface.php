<?php

namespace App\Interfaces\Model\RequestManagement;

use App\Interfaces\Traits\HasFinancialInterface;
use App\Interfaces\Traits\HasIdInterface;
use App\Interfaces\Traits\HasLeaveInterface;
use App\Interfaces\Traits\HasPriceCheckInterface;
use App\Interfaces\Traits\HasRequestedToInterface;
use App\Interfaces\Traits\HasRequestTypeInterface;
use App\Interfaces\Traits\HasResultInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasTextInterface;
use App\Interfaces\Traits\HasUserIdInterface;

interface RequestManagementInterface extends HasResultInterface, HasRequestTypeInterface, HasRequestedToInterface,
    HasStatusInterface, HasFinancialInterface, HasLeaveInterface, HasPriceCheckInterface, HasUserIdInterface,
    HasTextInterface, HasIdInterface

{
    const TABLE = 'request_management';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function receiver(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function getUserInformationAttribute(): string;

}
