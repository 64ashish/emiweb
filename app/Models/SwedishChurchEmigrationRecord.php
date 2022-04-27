<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishChurchEmigrationRecord extends Model
{
    use HasFactory, Searchable;


    public function archive(){
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'last_resident' => $this->last_resident,
            'profession' => $this->profession,
            'destination_country' => $this->destination_country,
            'from_parish' => $this->from_parish,
        ];
    }
}
