<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'invoice', 'name', 'mobile', 'fathers_name', 'mothers_name',
        'address', 'nationality', 'profession', 'company', 'comming_form', 'purpose',
        'checking_date_time', 'checkout_date_time', 'room_category', 'room_number', 
        'room_price', 'person', 'duration_day', 'total_price', 'nid_no', 'passport_no', 
        'visa_no', 'advance', 'payment_status', 'payment_method', 'check_status', 'status',
        'nid_doc', 'couple_doc', 'passport_doc', 'visa_doc', 'other_doc'
    ];

    protected $casts = [
        'nid_doc' => 'array',        // Ensuring the JSON fields are treated as arrays
        'couple_doc' => 'array',
        'passport_doc' => 'array',
        'visa_doc' => 'array',
        'other_doc' => 'array',
    ];
}
