<?php

namespace App\Interfaces\Model\CustomerInvoice;

use App\Interfaces\Traits\HasCustomerInvoiceInterface;
use App\Interfaces\Traits\HasIdInterface;

interface CustomerInvoiceInterface extends HasCustomerInvoiceInterface, HasIdInterface
{
    const TABLE = 'customer_invoices';
}
