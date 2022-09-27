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
        'archives_name',
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


    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name' ))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name' ))),
            'suffix'=>__(ucfirst(str_replace('_', ' ', 'suffix' ))),
            'alias_prefix'=>__(ucfirst(str_replace('_', ' ', 'alias_prefix' ))),
            'alias_given'=>__(ucfirst(str_replace('_', ' ', 'alias_given' ))),
            'alias_surname'=>__(ucfirst(str_replace('_', ' ', 'alias_surname' ))),
            'alias_suffix'=>__(ucfirst(str_replace('_', ' ', 'alias_suffix' ))),
            'gender'=>__(ucfirst(str_replace('_', ' ', 'gender' ))),
            'nativity'=>__(ucfirst(str_replace('_', ' ', 'nativity' ))),
            'ethnicity_nationality'=>__(ucfirst(str_replace('_', ' ', 'ethnicity_nationality' ))),
            'last_residence'=>__(ucfirst(str_replace('_', ' ', 'last_residence' ))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date' ))),
            'birthday'=>__(ucfirst(str_replace('_', ' ', 'birthday' ))),
            'birth_month'=>__(ucfirst(str_replace('_', ' ', 'birth_month' ))),
            'birth_year'=>__(ucfirst(str_replace('_', ' ', 'birth_year' ))),
            'ship_name'=>__(ucfirst(str_replace('_', ' ', 'ship_name' ))),
            'port_of_departure'=>__(ucfirst(str_replace('_', ' ', 'port_of_departure' ))),
            'port_of_arrival'=>__(ucfirst(str_replace('_', ' ', 'port_of_arrival' ))),
            'port_arrival_state'=>__(ucfirst(str_replace('_', ' ', 'port_arrival_state' ))),
            'port_arrival_country'=>__(ucfirst(str_replace('_', ' ', 'port_arrival_country' ))),
            'arrival_day'=>__(ucfirst(str_replace('_', ' ', 'arrival_day' ))),
            'arrival_month'=>__(ucfirst(str_replace('_', ' ', 'arrival_month' ))),
            'arrival_year'=>__(ucfirst(str_replace('_', ' ', 'arrival_year' ))),
            'age'=>__(ucfirst(str_replace('_', ' ', 'age' ))),
            'age_months'=>__(ucfirst(str_replace('_', ' ', 'age_months' ))),
            'place_of_origin'=>__(ucfirst(str_replace('_', ' ', 'place_of_origin' ))),
            'archives_name'=>__(ucfirst(str_replace('_', ' ', 'archives_name' ))),
            'archive_location'=>__(ucfirst(str_replace('_', ' ', 'archive_location' ))),
            'series_number'=>__(ucfirst(str_replace('_', ' ', 'series_number' ))),
            'record_group_name'=>__(ucfirst(str_replace('_', ' ', 'record_group_name' ))),
            'record_group_number'=>__(ucfirst(str_replace('_', ' ', 'record_group_number' ))),
            'friend_prefix'=>__(ucfirst(str_replace('_', ' ', 'friend_prefix' ))),
            'friend_given'=>__(ucfirst(str_replace('_', ' ', 'friend_given' ))),
            'friend_surname'=>__(ucfirst(str_replace('_', ' ', 'friend_surname' ))),
            'friend_suffix'=>__(ucfirst(str_replace('_', ' ', 'friend_suffix' ))),
            'microfilm_roll'=>__(ucfirst(str_replace('_', ' ', 'microfilm_roll' ))),
            'destination'=>__(ucfirst(str_replace('_', ' ', 'destination' ))),
            'family_id'=>__(ucfirst(str_replace('_', ' ', 'family_id' ))),
            'birth_other'=>__(ucfirst(str_replace('_', ' ', 'birth_other' ))),
            'form_type'=>__(ucfirst(str_replace('_', ' ', 'form_type' ))),
            'comments'=>__(ucfirst(str_replace('_', ' ', 'comments' ))),
            'image_file_name'=>__(ucfirst(str_replace('_', ' ', 'image_file_name' ))),
            'image_folder'=>__(ucfirst(str_replace('_', ' ', 'image_folder' ))),
            'prefix'=>__(ucfirst(str_replace('_', ' ', 'prefix' ))),
            'page_number'=>__(ucfirst(str_replace('_', ' ', 'page_number' ))),
            'airline'=>__(ucfirst(str_replace('_', ' ', 'airline' ))),
            'flight_number'=>__(ucfirst(str_replace('_', ' ', 'flight_number' ))),
            'list_number'=>__(ucfirst(str_replace('_', ' ', 'list_number' ))),
            'ship_id'=>__(ucfirst(str_replace('_', ' ', 'ship_id' ))),
            'image_number'=>__(ucfirst(str_replace('_', ' ', 'image_number' ))),
            'microfilm_serial'=>__(ucfirst(str_replace('_', ' ', 'microfilm_serial' ))),
            'arrival_month_no'=>__(ucfirst(str_replace('_', ' ', 'arrival_month_no' ))),

//            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes' ))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

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
    public function user(){
        return $this->belongsTo(User::class);
    }
}
