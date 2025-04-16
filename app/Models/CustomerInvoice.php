<?php

namespace App\Models;

use App\Interfaces\Model\CustomerInvoice\CustomerInvoiceInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model implements CustomerInvoiceInterface
{
    use HasFactory;

    protected $table = self::TABLE;

    protected $fillable = [
        self::ADMIN_ID,
        self::USER_ID,
        self::AIRLINE_ID,
        self::INVOICE_ACCOUNT_ID,
        self::SELECTED_DATE,
        self::WAYBILL_NO,
        self::NATURE_OF_THE_GOODS,
        self::ORIGIN_AIRPORT,
        self::DESTINATION_AIRPORT,
        self::CALCULATED_WEIGHT,
        self::AIRLINE_NAME,
        self::PRICE_DETAIL,
        self::TOTAL_PRICE,
    ];

    protected $casts = [
        'price_detail' => 'array'
    ];

    public function user()
    {
        return $this->hasOne(User::class,  self::ID, self::USER_ID);
    }

    public function airline()
    {
        return $this->hasOne(Airline::class,  self::ID, self::AIRLINE_ID);
    }

    public function invoiceAccount()
    {
        return $this->hasOne(InvoiceAccount::class,  self::ID, self::INVOICE_ACCOUNT_ID);
    }

    public function loadDetail()
    {
        return $this->belongsTo(LoadDetail::class, 'user_id', 'user_id');
    }

    public function getUserInformationAttribute()
    {
        return ($this?->user?->lastname || $this?->user?->name) ? $this?->user?->name . ' ' . $this?->user?->lastname : '-';
    }


}
