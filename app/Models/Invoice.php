<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice',
        'booking_id',
        'name',
        'profession',
        'company',
        'mobile',
        'checking_date_time',
        'checkout_date_time',
        'room_type',
        'person',
        'comming_from',
        'room_price',
        'duration',
        'total_price',
        'advance',
        'discount',
        'final_amount',
        'payment_status',
        'payment_method',
        'extra-1',
        'extra-2',
        'extra-3',
        'extra-4',
        'extra-5',
    ];
    
}
