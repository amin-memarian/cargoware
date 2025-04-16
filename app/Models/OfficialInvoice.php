<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficialInvoice extends Model
{
    protected $fillable = [
        'admin_id',
        'user_id',
        'airline_id',
        'invoice_account_id',
        'selected_date',
        'waybill_no',
        'nature_of_the_goods',
        'origin_airport',
        'destination_airport',
        'calculated_weight',
        'airline_name',
        'price_detail',
        'total_price',

        'customer_postal_code',
        'customer_economic_number',
        'customer_address',
        'customer_national_id',
        'customer_telephone'
    ];




    protected $casts = [
        'price_detail' => 'array'
    ];

    public function user()
    {
        return $this->hasOne(User::class,  'id', 'user_id');
    }

    public function airline()
    {
        return $this->hasOne(Airline::class,  'id', 'airline_id');
    }

    public function invoiceAccount()
    {
        return $this->hasOne(InvoiceAccount::class,  'id', 'invoice_account_id');
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
