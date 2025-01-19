<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Table name

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'fathers_name',
        'mothers_name',
        'address',
        'nationality',
        'profession',
        'company',
        'comming_form',
        'purpose',
        'checking_date_time',
        'checkout_date_time',
        'room_category',
        'room_number',
        'room_price',
        'person',
        'duration_day',
        'total_price',
        'nid_no',
        'nid_doc',
        'couple_doc',
        'passport_no',
        'passport_doc',
        'visa_no',
        'visa_doc',
        'other_doc',
        'advance',
        'payment_status',
        'payment_method',
        'check_status',
        'status',
        'invoice',
    ];
}
