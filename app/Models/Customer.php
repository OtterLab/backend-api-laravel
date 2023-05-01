<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'firstname',
        'surname',
        'address',
        'city',
        'country',
        'phone',
        'email'
    ];

    // Relationship user model
    public function user() {
        return $this->belongsTo(User::class);
    }
}
