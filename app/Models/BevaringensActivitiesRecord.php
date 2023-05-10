<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BevaringensActivitiesRecord extends Model
{
    use HasFactory;


    public function BevaringensLevnadsbeskrivningarRecord()
    {
        return $this->belongsTo(BevaringensLevnadsbeskrivningarRecord::class);
    }
}
