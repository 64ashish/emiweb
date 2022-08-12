<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NewYorkPassengerRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'suffix',
        'alias_prefix',
        'alias_given',
        'alias_surname',
        'alias_suffix',
        'gender',
        'nativity',
        'ethnicity_nationality',
        'last_residence',
        'birth_date',
        'birthday',
        'birth_month',
        'birth_year',
        'ship_name',
        'port_of_departure',
        'port_of_arrival',
        'port_arrival_state',
        'port_arrival_country',
        'arrival_day',
        'arrival_month',
        'arrival_year',
        'age',
        'age_months',
        'place_of_origin',
        'archive_name',
        'archive_location',
        'series_number',
        'record_group_name',
        'record_group_number',
        'friend_prefix',
        'friend_given',
        'friend_surname',
        'friend_suffix',
        'microfilm_roll',
        'destination',
        'family_id',
        'birth_other',
        'form_type',
        'comments',
        'image_file_name',
        'image_folder',
        'prefix',

        'page_number',
        'airline',
        'flight_number',
        'list_number',
        'ship_id',
        'image_number',
        'microfilm_serial',
        'arrival_month_no'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'suffix' => $this->suffix,
            'alias_prefix' => $this->alias_prefix,
            'alias_given' => $this->alias_given,
            'alias_surname' => $this->alias_surname,
            'alias_suffix' => $this->alias_suffix,
            'gender' => $this->gender,
            'nativity' => $this->nativity,
            'ethnicity_nationality' => $this->ethnicity_nationality,
            'last_residence' => $this->last_residence,
            'ship_name' => $this->ship_name,
            'place_of_origin' => $this->place_of_origin,
            'archive_location' => $this->archive_location,
            'destination' => $this->destination,
            'arrival_year' => $this->arrival_year,
            'birth_year' => $this->birth_year,
            'port_arrival_state' => $this->port_arrival_state,
            'port_of_arrival' => $this->port_of_arrival,
            'port_of_departure' => $this->port_of_departure
        ];
    }

    public function defaultSearchFields(){
        return [
//            'first_name',
//            'last_name',
            'gender',
            'nativity',
            'birth_date',
            'archive_location',
        ];
    }

    public function defaultTableColumns(){
        return [
            'gender',
            'ethnicity_nationality',
            'birthday',
            'port_of_departure',
            'place_of_origin',
            'destination'
        ];
    }
}
