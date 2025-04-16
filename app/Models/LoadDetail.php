<?php

namespace App\Models;

use App\Interfaces\Model\LoadDetail\LoadDetailInterfaceStart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoadDetail extends Model implements LoadDetailInterfaceStart
{
    use HasFactory, SoftDeletes;

    const NORMAL = 'normal';
    const SPECIAL = 'special';

    protected $table = self::TABLE;

    protected $fillable = [
        'payment_status',
        'has_invoice',
        'invoice_image_path',
        self::CASE_NUMBER,
        self::ADMIN_ID,
        self::USER_ID,
        self::ESTIMATE_ID,
        self::LOAD_TYPE,
        self::SPECIAL_LOAD_DESCRIPTION,
        self::POSTAL_CODE,
        self::ADDRESS,
        self::PHONE_NUMBER,
        self::IS_BULK,
        self::IS_URGENT,
        self::COLLECTION_DATE,
        self::START_COLLECTION_TIME,
        self::END_COLLECTION_TIME,
        self::DELIVERY_DATE,
        self::REJECTION_REASON,
        self::FLOORS_COUNT,
        self::ELEVATOR,
        self::PACKING,
        self::FAST_SHIPPING,
        'user_region',
        'collection_agent_type_id',
        'package_count',
        'name',
        'national_id',
        'receiver_name',
        'receiver_address',
        'receiver_phone',
        'receiver_postal_code',
        'receiver_email',
        'declared_value',
        'collection_address',
        'collection_postal_code',
        'handling_information',
        'main_box',
        'declared_value_for_destination',
        'nature_id',
        'vehicle_type_id',
        'collection_agent_id',
        'has_collection_cost',
        'has_warehouse_cost',
        'has_customs_cost'
    ];

    protected $attributes = [
        'payment_status' => '0',
        'has_invoice' => '0',
        'has_collection_cost' => '0',
        'has_warehouse_cost' => '0',
        'has_customs_cost' => '0'
    ];

    // State constants
    public const STATE_ORDER_REGISTERED = 'Order Registered';
    public const STATE_COLLECTION_STATUS = 'Collection Status';
    public const STATE_WAREHOUSING = 'Warehousing';
    public const STATE_CUSTOMS_FORMALITIES = 'Customs Formalities';
    public const STATE_BILL_OF_LADING_ISSUED = 'Bill of Lading Issued';
    public const STATE_FLIGHT_RESERVED = 'Flight Reserved';
    public const STATE_INVOICE_ISSUED = 'Invoice Issued';
    public const STATE_SHIPMENT_SENT = 'Shipment Sent';

    public static array $stateTranslations = [
        'Order Registered' => 'ثبت سفارش',
        'Collection Status' => 'در حال جمع آوری',
        'Warehousing' => 'انبارداری',
        'Customs Formalities' => 'تشریفات گمرکی',
        'Bill of Lading Issued' => 'صدور بارنامه',
        'Flight Reserved' => 'رزرو پرواز',
        'Invoice Issued' => 'صدور فاکتور',
        'Shipment Sent' => 'ارسال کالا',
    ];


    // Region constants
    public const REGION_NORTH = 'North';
    public const REGION_SOUTH = 'South';
    public const REGION_EAST = 'East';
    public const REGION_WEST = 'West';
    public const REGION_NORTHWEST = 'Northwest';
    public const REGION_NORTHEAST = 'Northeast';
    public const REGION_SOUTHWEST = 'Southwest';
    public const REGION_SOUTHEAST = 'Southeast';

    public static array $regionTranslations = [
        'North' => 'شمال',
        'South' => 'جنوب',
        'East' => 'شرق',
        'West' => 'غرب',
        'Northwest' => 'شمال غربی',
        'Northeast' => 'شمال شرقی',
        'Southwest' => 'جنوب غربی',
        'Southeast' => 'جنوب شرقی',
    ];


    public function estimate(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Estimate::class, self::ESTIMATE_ID)->withTrashed();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, self::USER_ID);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, self::ADMIN_ID);
    }

    public function nature(): BelongsTo
    {
        return $this->belongsTo(Nature::class);
    }

    public function loads(): BelongsTo
    {
        return $this->belongsTo(Load::class, 'load_id');
    }

    public function collectionAgentType(): BelongsTo
    {
        return $this->belongsTo(CollectionAgentType::class);
    }

    public function waybill(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Waybill::class, 'estimate_id', 'estimate_id');
    }

    public function packingList(): BelongsTo
    {
        return $this->belongsTo(PackingList::class, 'load_id', 'load_id');
    }

    // Accessors
    // Accessor for state translation
    public function getPersianStateAttribute($value)
    {
        return self::$stateTranslations[$value] ?? $value; // Return the Persian equivalent or the original value
    }

    public function getPersianRegionAttribute($value)
    {
        return self::$regionTranslations[$value] ?? $value; // Return the Persian equivalent or the original value
    }

    public function getAdminInformationAttribute()
    {
        return ($this?->admin?->lastname || $this?->admin?->mobile) ? $this?->admin?->lastname . ' ' . $this?->admin?->mobile : '-';
    }

    public function getAdminInformationForOrderAttribute()
    {
        return ($this?->admin?->lastname || $this?->admin?->name) ? $this?->admin?->name . ' ' . $this?->admin?->lastname : '-';
    }

    public function getWeightAttribute()
    {
        return $this?->estimate?->loads?->weight ?: '-';
    }

    public function getCountAttribute()
    {
        return $this?->estimate?->loads?->count ?: '-';
    }

    public function getSizeWidthAttribute()
    {
        return $this?->estimate?->loads?->size_width ?: '-';
    }

    public function getSizeHeightAttribute()
    {
        return $this?->estimate?->loads?->size_height ?: '-';
    }

    public function getSizeLengthAttribute()
    {
        return $this?->estimate?->loads?->size_length ?: '-';
    }

    public function getVolumeWeightAttribute()
    {
        return $this?->estimate?->loads?->volume_weight ?: '-';
    }

    public function getPartnersAttribute()
    {
        $result = null;
        if ($this?->user) {
            $partners = Partner::query()->where('user_id', $this?->user->id)->get();
            if ($partners) {

                foreach ($partners as $partner) {
                    $result .= $partner?->users?->lastname . ' ' . $partner?->users?->mobile . ' | ';
                }
                return $result;
            }
        }
        return 'بازاریاب ندارد';
    }

    public function getDestinationAttribute()
    {
        return $this->estimate->loads?->address ?: '-';
    }

    public function getOriginAttribute()
    {
        return $this->estimate->loads?->store ?: '-';
    }

    // Helpers
    // About define order state in show order
    public function checkLoadState($modelState, $constState)
    {
        return $modelState === $constState ? 'completed' : '';
    }

    public function collectionAgentRequest(): HasOne
    {
        return $this->hasOne(CollectionAgentRequest::class);
    }

    public function collectionAgent()
    {
        return $this->belongsTo(CollectionAgent::class, 'collection_agent_id');
    }

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }

    public function collectionCost()
    {
        return $this->belongsTo(CollectionCost::class, 'id', 'load_detail_id');
    }

    public function warehouseCost()
    {
        return $this->belongsTo(WarehouseCost::class, 'id', 'load_detail_id');
    }

    public function customsCost()
    {
        return $this->belongsTo(CustomsCost::class, 'id', 'load_detail_id');
    }

}
