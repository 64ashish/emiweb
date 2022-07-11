<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relatives extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name','relationship_type','archive_id','archive','record_id','item_id'
    ];
}
