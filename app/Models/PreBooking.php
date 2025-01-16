<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreBooking extends Model
{
    protected $fillable = [
        'date_time', 
        'name', 
        'nationality', 
        'company', 
        'phone', 
        'person', 
        'room_category', 
        'room_number', 
        'room_price', 
        'duration_day', 
        'booking_by'
    ];

    protected $casts = [
        'date_time' => 'datetime',  // Cast 'date_time' to a DateTime instance
        'room_price' => 'decimal:2', // For decimal type with 2 places after decimal
        'duration_day' => 'integer',  // For integer type
    ];
}

