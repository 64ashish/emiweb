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
        'given',
        'surname',
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

}
