<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MormonShipPassengerRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'nationality',
        'residence',
        'residence_country',
        'ship_name',
        'profession',
        'comments',
        'family_nr',
        'birth_place',
        'birth_country',
        'age',
        'conference',
        'travel_type',
        'departure_year',
        'departure_month',
        'departure_day',
        'destination',
        'dgsnr',
        'image_nr',
        'gsnumber',
        'gender',
        'entry',
        'inclusive_dates',
        'libr_no',
        'volume_nr',

    ];

    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'nationality'=>__(ucfirst(str_replace('_', ' ', 'nationality'))),
            'residence'=>__(ucfirst(str_replace('_', ' ', 'residence'))),
            'residence_country'=>__(ucfirst(str_replace('_', ' ', 'residence_country'))),
            'ship_name'=>__(ucfirst(str_replace('_', ' ', 'ship_name'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'comments'=>__(ucfirst(str_replace('_', ' ', 'comments'))),
            'family_nr'=>__(ucfirst(str_replace('_', ' ', 'family_nr'))),
            'birth_place'=>__(ucfirst(str_replace('_', ' ', 'birth_place'))),
            'birth_country'=>__(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'age'=>__(ucfirst(str_replace('_', ' ', 'age'))),
            'conference'=>__(ucfirst(str_replace('_', ' ', 'conference'))),
            'travel_type'=>__(ucfirst(str_replace('_', ' ', 'travel_type'))),
            'departure_date'=>__(ucfirst(str_replace('_', ' ', 'departure_date'))),
//            'departure_year'=>__(ucfirst(str_replace('_', ' ', 'departure_year'))),
//            'departure_month'=>__(ucfirst(str_replace('_', ' ', 'departure_month'))),
//            'departure_day'=>__(ucfirst(str_replace('_', ' ', 'departure_day'))),
            'destination'=>__(ucfirst(str_replace('_', ' ', 'destination'))),
            'dgsnr'=>__(ucfirst(str_replace('_', ' ', 'dgsnr'))),
            'image_nr'=>__(ucfirst(str_replace('_', ' ', 'image_nr'))),
            'gsnumber'=>__(ucfirst(str_replace('_', ' ', 'gsnumber'))),
            'gender'=>__(ucfirst(str_replace('_', ' ', 'gender'))),
            'entry'=>__(ucfirst(str_replace('_', ' ', 'entry'))),
            'inclusive_dates'=>__(ucfirst(str_replace('_', ' ', 'inclusive_dates'))),
            'libr_no'=>__(ucfirst(str_replace('_', ' ', 'libr_no'))),
            'volume_nr'=>__(ucfirst(str_replace('_', ' ', 'volume_nr'))),

//            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes' ))),
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
            'residence',
            'residence_country',
            'profession',
            '---',
            ['departure_year',
            'departure_month',
            'departure_day'],
            'conference',
            'destination',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'departure_year',
            'conference',
            'residence',
            'residence_country',
            'destination',
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

    public function getDepartureDateAttribute(){
        return $this->departure_year ."/".$this->departure_month."/".$this->departure_day;
    }

    public function searchFields()
    {
        return [

        ];
    }

}
