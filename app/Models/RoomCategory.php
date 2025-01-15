<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomCategory extends Model
{
    use HasFactory;

    // Define the table name (optional if it matches Laravel's convention)
    protected $table = 'room_categories';

    // Define the fillable fields
    protected $fillable = [
        'name',
    ];

    // Define relationships
    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_category_id'); // A category has many rooms
    }
}
