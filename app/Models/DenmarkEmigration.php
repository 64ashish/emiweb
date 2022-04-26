<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenmarkEmigration extends Model
{
    use HasFactory;

    public function Archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
