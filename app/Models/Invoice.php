<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'invoice_date',
        'description',
        'subtotal',
        'tax',
        'total'
    ];
}
