<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // Define the table name (optional if it matches Laravel's convention)
    protected $table = 'rooms';

    // Define the fillable fields
    protected $fillable = [
        'room_number',
        'room_name',
        'room_category_id',
        'price',
        'feature',
        'status',
    ];

    // Define relationships
    public function category()
    {
        return $this->belongsTo(RoomCategory::class, 'room_category_id'); // A room belongs to a category
    }
}
