<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class IcelandEmigrationRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'middle_name',
        'last_name',
        'original_name',
        'date_of_birth',
        'place_of_birth',
        'destination_country',
        'destination_location',
        'home_location',
        'departure',
        'profession',
        'travel_companion',
        'return_info',
        'travel_method',
        'fathers_name',
        'fathers_birth_location',
        'mothers_name',
        'mothers_birth_location',
        'civil_status',
        'partner_info',
        'children',
        'death_date',
        'death_location',
        'member_of_church',
        'reference',
        'genealogy',
        'source',
        'newspaper_info',
        'photo','distction',
        'member_of_organization',
        'comment'
    ];

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_name' => $this->other_name,
            'Description' => $this->Description,
            'date' => $this->date,
            'roll_no' => $this->roll_no,
            'file_name' => $this->file_name,
            'children'=> $this->children,
            'date_of_birth'=> $this->date_of_birth,
            'death_date'=> $this->death_date,
            'death_location'=> $this->death_location,
            'departure'=> $this->departure,
            'destination_country'=> $this->destination_country,
            'destination_location'=> $this->destination_location,
            'home_location'=> $this->home_location,
            'place_of_birth'=> $this->place_of_birth,
            'profession'=> $this->profession,
            'return_info'=> $this->return_info,
            'travel_method'=> $this->travel_method
        ];
    }

    public function defaultTableColumns(){
        return [
            'date_of_birth',
            'place_of_birth',
            'destination_country',
            'destination_location',
            'home_location',
            'profession',
        ];
    }
}
