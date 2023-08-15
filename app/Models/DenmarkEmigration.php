<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class DenmarkEmigration extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'organization_id',
        'first_name',
        'last_name',
        'sex',
        'age',
        'birth_place',
        'last_resident',
        'profession',
        'destination_city',
        'destination_country',
        'ship_name',
        'traveled_on',
        'contract_number',
        'comment',
        'secrecy',
        'travel_type',
        'source',
        'dduid'
    ];


    public function fieldsToDisply()
    {
        return [
            'first_name'=> __(ucfirst(str_replace('_', ' ', 'first_name'))) ,
            'last_name'=> __(ucfirst(str_replace('_', ' ', 'last_name'))) ,
            'sex'=> __(ucfirst(str_replace('_', ' ', 'sex'))) ,
            'age'=> __(ucfirst(str_replace('_', ' ', 'age'))) ,
            'birth_place'=> __(ucfirst(str_replace('_', ' ', 'birth_place'))) ,
            'last_resident'=> __(ucfirst(str_replace('_', ' ', 'last_resident'))) ,
            'profession'=> __(ucfirst(str_replace('_', ' ', 'profession'))) ,
            'destination_city'=> __(ucfirst(str_replace('_', ' ', 'destination_city'))) ,
            'destination_country'=> __(ucfirst(str_replace('_', ' ', 'destination_country'))) ,
            'ship_name'=> __(ucfirst(str_replace('_', ' ', 'ship_name'))) ,
            'traveled_on'=> __(ucfirst(str_replace('_', ' ', 'traveled_on'))) ,
            'contract_number'=> __(ucfirst(str_replace('_', ' ', 'contract_number'))) ,
            'comment'=> __(ucfirst(str_replace('_', ' ', 'comment'))) ,
            'secrecy'=> __(ucfirst(str_replace('_', ' ', 'secrecy'))) ,
            'travel_type'=> __(ucfirst(str_replace('_', ' ', 'travel_type'))) ,
            'source'=> __(ucfirst(str_replace('_', ' ', 'source'))) ,
            'dduid' => __(ucfirst(str_replace('_', ' ', ' dduid'))),
            'id' => 'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }



    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'age',
            'profession',
            'birth_place',
            'last_resident',
            '---',
            'traveled_on',
            'destination_country',
            'destination_city',
        ];
    }


    public function defaultTableColumns(){
        return [
            'birth_place',
            'last_resident',
            'traveled_on',
            'destination_city',
            'destination_country',

        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function enableQueryMatch(){
        return [
            'first_name',
            'last_name',
        ];
    }

    public function searchFields()
    {
        return [

        ];
    }


}
