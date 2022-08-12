<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorwayEmigrationRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

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

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultSearchFields(){
        return [
//            'first_name',
//            'last_name',
            'birth_date',
            'sex',
            'profession',
            'from_date',
            'from_location',
            'from_region',
            'destination_location',
            'destination_county',
            'destination_country',
            'birth_country',
            'birth_location',
        ];
    }
    public function defaultTableColumns(){
        return [
            'birth_place',
            'sex',
            'from_location',
            'profession',
            'destination_location',
            'destination_country',
        ];
    }
}
