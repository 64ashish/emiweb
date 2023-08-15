<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorwegianChurchImmigrantRecord extends Model
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
        'alone_or_family',
        'from_area',
        'from_country',
        'to_date',
        'to_location',
        'to_fylke',
        'certificates',
        'comment',
        'birth_location',
        'baptism_date',
        'baptism_location',
        'confirmation_date',
        'confirmation_location',
        'marriage_date',
        'marriage_location',
        'secrecy',
        'birth_country',
        'baptism_country',
        'confirmation_country',
        'marriage_country',
        'migration_cause',
        'registered_date',
        'from_county',
        'from_location',
        'signature',
        'farm_name',
        'source_type',
        'source_area',
        'source_book_nr',
        'source_period',
        'source_page_nr',
        'source_place',
        'family_nr',
        'nr_in_immigration_book',

    ];

    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'sex'=>__(ucfirst(str_replace('_', ' ', 'sex'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'alone_or_family'=>__(ucfirst(str_replace('_', ' ', 'alone_or_family'))),
            'from_area'=>__(ucfirst(str_replace('_', ' ', 'from_area'))),
            'from_country'=>__(ucfirst(str_replace('_', ' ', 'from_country'))),
            'to_date'=>__(ucfirst(str_replace('_', ' ', 'to_date'))),
            'to_location'=>__(ucfirst(str_replace('_', ' ', 'to_location'))),
            'to_fylke'=>__(ucfirst(str_replace('_', ' ', 'to_fylke'))),
            'certificates'=>__(ucfirst(str_replace('_', ' ', 'certificates'))),
            'comment'=>__(ucfirst(str_replace('_', ' ', 'comment'))),
            'birth_location'=>__(ucfirst(str_replace('_', ' ', 'birth_location'))),
            'baptism_date'=>__(ucfirst(str_replace('_', ' ', 'baptism_date'))),
            'baptism_location'=>__(ucfirst(str_replace('_', ' ', 'baptism_location'))),
            'confirmation_date'=>__(ucfirst(str_replace('_', ' ', 'confirmation_date'))),
            'confirmation_location'=>__(ucfirst(str_replace('_', ' ', 'confirmation_location'))),
            'marriage_date'=>__(ucfirst(str_replace('_', ' ', 'marriage_date'))),
            'marriage_location'=>__(ucfirst(str_replace('_', ' ', 'marriage_location'))),
            'secrecy'=>__(ucfirst(str_replace('_', ' ', 'secrecy'))),
            'birth_country'=>__(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'baptism_country'=>__(ucfirst(str_replace('_', ' ', 'baptism_country'))),
            'confirmation_country'=>__(ucfirst(str_replace('_', ' ', 'confirmation_country'))),
            'marriage_country'=>__(ucfirst(str_replace('_', ' ', 'marriage_country'))),
            'migration_cause'=>__(ucfirst(str_replace('_', ' ', 'migration_cause'))),
            'registered_date'=>__(ucfirst(str_replace('_', ' ', 'registered_date'))),
            'from_county'=>__(ucfirst(str_replace('_', ' ', 'from_county'))),
            'from_location'=>__(ucfirst(str_replace('_', ' ', 'from_location'))),
            'signature'=>__(ucfirst(str_replace('_', ' ', 'signature'))),
            'farm_name'=>__(ucfirst(str_replace('_', ' ', 'farm_name'))),
            'source_type'=>__(ucfirst(str_replace('_', ' ', 'source_type'))),
            'source_area'=>__(ucfirst(str_replace('_', ' ', 'source_area'))),
            'source_book_nr'=>__(ucfirst(str_replace('_', ' ', 'source_book_nr'))),
            'source_period'=>__(ucfirst(str_replace('_', ' ', 'source_period'))),
            'source_page_nr'=>__(ucfirst(str_replace('_', ' ', 'source_page_nr'))),
            'source_place'=>__(ucfirst(str_replace('_', ' ', 'source_place'))),
            'family_nr'=>__(ucfirst(str_replace('_', ' ', 'family_nr'))),
            'nr_in_immigration_book'=>__(ucfirst(str_replace('_', ' ', 'nr_in_immigration_book'))),
//            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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
//            'registered_date',
//            'to_fylke',
//            'to_location',
            'immigration_date',
            'immigration_county',
            'immigration_place',

        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            // 'sex',
            // 'profession',
            'birth_date',
            'birth_location',
            'to_date',
            'source_place',
            'to_fylke',
            'from_country',
            // 'baptism_location',
        ];
    }

//    protected $dates = ['birth_date'];
    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
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
            'civil_status'
        ];
    }
}
