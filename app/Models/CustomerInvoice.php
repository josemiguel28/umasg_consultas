<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerInvoice extends Model
{

    protected $table = 'invoices';

    protected $fillable = [
        'route_code',
        'customer_code',
        'owner_name',
        'address',
        'category',
        'status',
        'has_meter',
        'meter_code',
        'month_billed',
        'balance_water',
        'balance_sewer',
        'balance_other',
    ];
}
