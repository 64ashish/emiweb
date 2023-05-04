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
        'photo',
        'distction',
        'member_of_organization',
        'comment'
    ];


    public function fieldsToDisply()
    {
        return [

            'first_name' => __(ucfirst(str_replace('_', ' ', 'first_name' ))) ,
            'middle_name' => __(ucfirst(str_replace('_', ' ', 'middle_name' ))) ,
            'last_name' => __(ucfirst(str_replace('_', ' ', 'last_name' ))) ,
            'original_name' => __(ucfirst(str_replace('_', ' ', 'original_name' ))) ,
            'date_of_birth' => __(ucfirst(str_replace('_', ' ', 'date_of_birth' ))) ,
            'place_of_birth' => __(ucfirst(str_replace('_', ' ', 'place_of_birth' ))) ,
            'destination_country' => __(ucfirst(str_replace('_', ' ', 'destination_country' ))) ,
            'destination_location' => __(ucfirst(str_replace('_', ' ', 'destination_location' ))) ,
            'home_location' => __(ucfirst(str_replace('_', ' ', 'home_location' ))) ,
            'departure' => __(ucfirst(str_replace('_', ' ', 'departure' ))) ,
            'profession' => __(ucfirst(str_replace('_', ' ', 'profession' ))) ,
            'travel_companion' => __(ucfirst(str_replace('_', ' ', 'travel_companion' ))) ,
            'return_info' => __(ucfirst(str_replace('_', ' ', 'return_info' ))) ,
            'travel_method' => __(ucfirst(str_replace('_', ' ', 'travel_method' ))) ,
            'fathers_name' => __(ucfirst(str_replace('_', ' ', 'fathers_name' ))) ,
            'fathers_birth_location' => __(ucfirst(str_replace('_', ' ', 'fathers_birth_location' ))) ,
            'mothers_name' => __(ucfirst(str_replace('_', ' ', 'mothers_name' ))) ,
            'mothers_birth_location' => __(ucfirst(str_replace('_', ' ', 'mothers_birth_location' ))) ,
            'civil_status' => __(ucfirst(str_replace('_', ' ', 'civil_status' ))) ,
            'partner_info' => __(ucfirst(str_replace('_', ' ', 'partner_info' ))) ,
            'children' => __(ucfirst(str_replace('_', ' ', 'children' ))) ,
            'death_date' => __(ucfirst(str_replace('_', ' ', 'death_date' ))) ,
            'death_location' => __(ucfirst(str_replace('_', ' ', 'death_location' ))) ,
            'member_of_church' => __(ucfirst(str_replace('_', ' ', 'member_of_church' ))) ,
            'reference' => __(ucfirst(str_replace('_', ' ', 'reference' ))) ,
            'genealogy' => __(ucfirst(str_replace('_', ' ', 'genealogy' ))) ,
            'source' => __(ucfirst(str_replace('_', ' ', 'source' ))) ,
            'newspaper_info' => __(ucfirst(str_replace('_', ' ', 'newspaper_info' ))) ,
            'photo' => __(ucfirst(str_replace('_', ' ', 'photo' ))) ,
            'distction' => __(ucfirst(str_replace('_', ' ', 'distction' ))) ,
            'member_of_organization' => __(ucfirst(str_replace('_', ' ', 'member_of_organization' ))) ,
            'comment' => __(ucfirst(str_replace('_', ' ', 'comment' ))) ,
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

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

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'profession',
            'date_of_birth',
            'place_of_birth',
            'departure',
            'destination_country',
            'destination_location',
            'death_date',
            'death_location'
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'date_of_birth',
            'place_of_birth',
            'destination_country',
            'destination_location',
            'home_location',
            'profession',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function enableQueryMatch(){
        return [
            'first_name',
            'last_name',
        ];
    }

    public function searchFields()
    {
        return [];
    }
}
