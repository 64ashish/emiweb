<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorwayEmigrationRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'birth_date',
        'sex',
        'profession',
        'civil_status',
        'registered_date',
        'from_date',
        'from_location',
        'from_region',
        'destination_location',
        'destination_area',
        'destination_county',
        'destination_country',
        'certificates',
        'birth_country',
        'birth_location',
        'source_type',
        'source_area',
        'source_book_number',
        'source_period',
        'source_page_number',
        'source_place',
        'family_number',
        'number_in_emigration_book',
        'comment',
        'secrecy',
        'signature',
        'page_link',
        'image_link'
    ];

//    protected function address(): Attribute
//    {
//        return Attribute::make(
//            get: fn ($value, $attributes) => new Address(
//                $attributes['address_line_one'],
//                $attributes['address_line_two'],
//            ),
//        );
//    }




    public function fieldsToDisply()
    {
        return [
            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'sex'=>__(ucfirst(str_replace('_', ' ', 'sex'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'registered_date'=>__(ucfirst(str_replace('_', ' ', 'registered_date'))),
            'from_date'=>__(ucfirst(str_replace('_', ' ', 'from_date'))),
            'from_location'=>__(ucfirst(str_replace('_', ' ', 'from_location'))),
            'from_region'=>__(ucfirst(str_replace('_', ' ', 'from_region'))),
            'destination_location'=>__(ucfirst(str_replace('_', ' ', 'destination_location'))),
            'destination_area'=>__(ucfirst(str_replace('_', ' ', 'destination_area'))),
            'destination_county'=>__(ucfirst(str_replace('_', ' ', 'destination_county'))),
            'destination_country'=>__(ucfirst(str_replace('_', ' ', 'destination_country'))),
            'certificates'=>__(ucfirst(str_replace('_', ' ', 'certificates'))),
            'birth_country'=>__(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'birth_location'=>__(ucfirst(str_replace('_', ' ', 'birth_location'))),
            'source_type'=>__(ucfirst(str_replace('_', ' ', 'source_type'))),
            'source_area'=>__(ucfirst(str_replace('_', ' ', 'source_area'))),
            'source_book_number'=>__(ucfirst(str_replace('_', ' ', 'source_book_number'))),
            'source_period'=>__(ucfirst(str_replace('_', ' ', 'source_period'))),
            'source_page_number'=>__(ucfirst(str_replace('_', ' ', 'source_page_number'))),
            'source_place'=>__(ucfirst(str_replace('_', ' ', 'source_place'))),
            'family_number'=>__(ucfirst(str_replace('_', ' ', 'family_number'))),
            'number_in_emigration_book'=>__(ucfirst(str_replace('_', ' ', 'number_in_emigration_book'))),
            'comment'=>__(ucfirst(str_replace('_', ' ', 'comment'))),
            'secrecy'=>__(ucfirst(str_replace('_', ' ', 'secrecy'))),
            'signature'=>__(ucfirst(str_replace('_', ' ', 'signature'))),
            'page_link'=>__(ucfirst(str_replace('_', ' ', 'page_link'))),
            'image_link'=>__(ucfirst(str_replace('_', ' ', 'image_link'))),
//            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'birth_date',
            'birth_country',
            'birth_location',
            '---',
//            'registered_date',
//            'to_fylke',
//            'to_location',
            'emigration_date',
            'emigration_county',
            'emigration_place'
        ];
    }
    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'birth_date',
            'birth_place',
            'from_date',
            'from_location',
            'from_region',
            'destination_country',
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
        return [
            'sex',
            'from_country',
            'from_county',
            'comment',
            'profession',
            'civil_status',
        ];
    }
}
