<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'country',
        'location',
        'city',
        'notes',
        'postcode',
        'is_deleted',
    ];

    // Resten av din modellkod...
}
