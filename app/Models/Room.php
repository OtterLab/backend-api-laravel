<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\Models\RoomCapacity;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'room_type_id',
        'room_capacity_id',
        'room_image'
    ];

    // define model relationship
    public function roomType() {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function roomCapacity() {
        return $this->belongsTo(RoomCapacity::class, 'room_capacity_id');
    }

    public function roomPrice() {
        return "550";
    }
}
