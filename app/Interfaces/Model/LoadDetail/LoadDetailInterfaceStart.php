<?php

namespace App\Interfaces\Model\LoadDetail;

use App\Interfaces\Traits\HasAddressInterface;
use App\Interfaces\Traits\HasAdminIdInterface;
use App\Interfaces\Traits\HasCaseNumberInterface;
use App\Interfaces\Traits\HasCollectionDateInterface;
use App\Interfaces\Traits\HasElevatorInterface;
use App\Interfaces\Traits\HasEndCollectionTimeInterface;
use App\Interfaces\Traits\HasEstimateIdInterface;
use App\Interfaces\Traits\HasFastShippingInterface;
use App\Interfaces\Traits\HasFloorsCountInterface;
use App\Interfaces\Traits\HasPackingInterface;
use App\Interfaces\Traits\HasRegionInterface;
use App\Interfaces\Traits\HasRejectionReasonInterface;
use App\Interfaces\Traits\HasStartCollectionTimeInterface;
use App\Interfaces\Traits\HasDeliveryDateInterface;
use App\Interfaces\Traits\HasIsBulkInterface;
use App\Interfaces\Traits\HasIsUrgentInterface;
use App\Interfaces\Traits\HasLoadTypeInterface;
use App\Interfaces\Traits\HasPhoneNumberInterface;
use App\Interfaces\Traits\HasPostalCodeInterface;
use App\Interfaces\Traits\HasSpecialLoadDescriptionInterface;
use App\Interfaces\Traits\HasStatusInterface;
use App\Interfaces\Traits\HasUserIdInterface;
use App\Interfaces\Traits\HasWeightInterface;

interface LoadDetailInterfaceStart extends HasLoadTypeInterface, HasSpecialLoadDescriptionInterface, HasPostalCodeInterface, HasAddressInterface,
    HasPhoneNumberInterface, HasIsUrgentInterface, HasIsBulkInterface, HasCollectionDateInterface, HasStartCollectionTimeInterface,
    HasDeliveryDateInterface, HasEndCollectionTimeInterface, HasUserIdInterface, HasEstimateIdInterface, HasAdminIdInterface, HasRejectionReasonInterface,
    HasCaseNumberInterface, HasElevatorInterface, HasPackingInterface, HasFastShippingInterface, HasFloorsCountInterface,
    HasRegionInterface, HasWeightInterface
{
    const TABLE = 'load_details';

    public function estimate(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo;

}
