<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishPortPassengerListRecord extends Model
{
    use HasFactory, RecordCount, Searchable;

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

    public function toSearchableArray()
    {
        return [
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'age'=> $this->age,
            'sex'=> $this->sex,
            'profession'=> $this->profession,
            'departure_parish'=> $this->departure_parish,
            'destination'=> $this->destination,
            'source_reference'=> $this->source_reference,
            'departure_county'=> $this->departure_county,
            'traveling_partners'=> $this->traveling_partners,
            'departure_port'=> $this->departure_port,
            'comments'=> $this->comments,
            'departure_date' => $this->departure_date,
            'main_act' => $this->main_act
        ];
    }
}
