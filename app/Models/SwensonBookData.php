<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwensonBookData extends Model
{
    use HasFactory;

    public function SwedishAmericanBookRecords()
    {
        return $this->hasMany(SwedishAmericanBookRecord::class);
    }

    public function enableQueryMatch(){
        return [
        ];
    }
}
