<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'room_type_id',
        'room_capacity_id',
        'day',
        'start_date',
        'end_date'
    ];
}
