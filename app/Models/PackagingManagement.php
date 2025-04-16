<?php

namespace App\Models;

use App\Interfaces\Model\PackagingManagement\PackagingManagementInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingManagement extends Model implements PackagingManagementInterface
{
    use HasFactory;

    protected $table = self::TABLE;

    protected $fillable = [
        self::PACKING_WAGE_PROFIT,
        self::COST_OF_FULL_AIR_PALLET_PACKAGING_PARTNER,
        self::COST_OF_FULL_AIR_PALLET_PACKAGING_CUSTOMER,
        self::COST_OF_HALF_AIR_PALLET_PACKAGING_PARTNER,
        self::COST_OF_HALF_AIR_PALLET_PACKAGING_CUSTOMER,
        self::COST_OF_QUARTER_AIR_PALLET_PACKAGING_PARTNER,
        self::COST_OF_QUARTER_AIR_PALLET_PACKAGING_CUSTOMER,
        self::COST_OF_FULL_SEA_PALLET_PACKAGING_PARTNER,
        self::COST_OF_FULL_SEA_PALLET_PACKAGING_CUSTOMER,
        self::COST_OF_MEDIUM_SHRINK_AND_STRAPPING_PARTNER,
        self::COST_OF_MEDIUM_SHRINK_AND_STRAPPING_CUSTOMER,
    ];

    /*
     * Translations for fields used in the create, edit, and index pages.
     *
     *
     * Please ensure that these fields are never removed or modified without careful consideration, as they are essential for the proper functionality of the application.
     */
    public static array $fieldsTranslations = [
        self::PACKING_WAGE_PROFIT => 'سود دستمزد بسته بندی',
        self::COST_OF_FULL_AIR_PALLET_PACKAGING_PARTNER => 'هزینه بسته بندی 1 پالت کامل هوایی (مبلغ همکار)',
        self::COST_OF_FULL_AIR_PALLET_PACKAGING_CUSTOMER => 'هزینه بسته بندی 1 پالت کامل هوایی (مبلغ مشتری)',
        self::COST_OF_HALF_AIR_PALLET_PACKAGING_PARTNER => 'هزینه بسته بندی نیم پالت هوایی (مبلغ همکار)',
        self::COST_OF_HALF_AIR_PALLET_PACKAGING_CUSTOMER => 'هزینه بسته بندی نیم پالت هوایی (مبلغ مشتری)',
        self::COST_OF_QUARTER_AIR_PALLET_PACKAGING_PARTNER => 'هزینه بسته بندی ربع پالت هوایی (مبلغ همکار)',
        self::COST_OF_QUARTER_AIR_PALLET_PACKAGING_CUSTOMER => 'هزینه بسته بندی ربع پالت هوایی (مبلغ مشتری)',
        self::COST_OF_FULL_SEA_PALLET_PACKAGING_PARTNER => 'هزینه بسته بندی 1 پالت کامل دریایی (مبلغ همکار)',
        self::COST_OF_FULL_SEA_PALLET_PACKAGING_CUSTOMER => 'هزینه بسته بندی 1 پالت کامل دریایی (مبلغ مشتری)',
        self::COST_OF_MEDIUM_SHRINK_AND_STRAPPING_PARTNER => 'هزینه شیرینک و تسمه کشی بسته متوسط (مبلغ همکار)',
        self::COST_OF_MEDIUM_SHRINK_AND_STRAPPING_CUSTOMER => 'هزینه شیرینک و تسمه کشی بسته متوسط (مبلغ مشتری)',
    ];

}
