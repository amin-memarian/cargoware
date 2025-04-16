<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAccount extends Model
{
    use HasFactory;

    protected $table = 'invoice_accounts';

    protected $fillable = [
        'bank_name',
        'branch',
        'code',
        'account_holder',
        'card_number',
        'account_number',
        'sheba_number'
    ];

}
