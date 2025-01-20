<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suport extends Model
{
    protected $fillable = [
        'name',
        'subject',
        'phone',
        'massage',
        'status',
    ];
}
