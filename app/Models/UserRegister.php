<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRegister extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
