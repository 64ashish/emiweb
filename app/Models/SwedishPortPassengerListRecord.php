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


    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'age'=>__(ucfirst(str_replace('_', ' ', 'age'))),
            'sex'=>__(ucfirst(str_replace('_', ' ', 'sex'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'departure_date'=>__(ucfirst(str_replace('_', ' ', 'departure_date'))),
            'departure_parish'=>__(ucfirst(str_replace('_', ' ', 'departure_parish'))),
            'destination'=>__(ucfirst(str_replace('_', ' ', 'destination'))),
            'source_reference'=>__(ucfirst(str_replace('_', ' ', 'source_reference'))),
            'departure_county'=>__(ucfirst(str_replace('_', ' ', 'departure_county'))),
            'traveling_partners'=>__(ucfirst(str_replace('_', ' ', 'traveling_partners'))),
            'main_act'=>__(ucfirst(str_replace('_', ' ', 'main_act'))),
            'departure_port'=>__(ucfirst(str_replace('_', ' ', 'departure_port'))),
            'comments'=>__(ucfirst(str_replace('_', ' ', 'comments'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

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

    public function defaultSearchFields()
    {
        return [
//            'first_name',
//            'last_name',
            'age',
            'sex',
            'profession',
            'departure_date',
            'departure_parish',
            'destination',
            'departure_county',
            'departure_port',
        ];
    }

    public function defaultTableColumns(){
        return [
            'age',
            'sex',
            'profession',
            'departure_date',
            'destination',
            'departure_county',
        ];
    }
}
