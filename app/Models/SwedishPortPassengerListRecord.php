<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwedishPortPassengerListRecord extends Model
{
    use HasFactory, RecordCount;

    protected $fillable = [
        'old_id',
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'age',
        'sex',
        'profession',
        'departure_date',
        'departure_parish',
        'destination',
        'source_reference',
        'departure_county',
        'traveling_partners',
        'main_act',
        'departure_port',
        'comments'
    ];


    public function Archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
