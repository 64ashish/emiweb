<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishAmericanChurchArchiveRecord extends Model
{
    use HasFactory, RecordCount;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'last_name2',
        'gender',
        'civil_status',
        'birth_date',
        'birth_parish',
        'birth_province',
        'immigration_date',
        'emigration_parish',
        'emigration_province',
        'arrival_date_this_place',
        'arrived_from_place',
        'arrived_from_county',
        'arrived_from_state',
        'death_date',
        'family_nr',
        'source',
        'immigrated_to_place',
        'immigrated_to_state',
        'old_id',
        'birth_year',
        'birth_month',
        'birth_day',
        'immigration_year',
        'immigration_month',
        'immigration_day',
        'death_year',
        'death_month',
        'death_day',
        'page',
    ];

    /**
     * Get the fields to display.
     *
     * @return array
     */
    public function fieldsToDisplay()
    {
        return [
            'first_name' => __(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name' => __(ucfirst(str_replace('_', ' ', 'last_name'))),
            // 'last_name2'=>__(ucfirst(str_replace('_', ' ', 'last_name2'))),
            'birth_date' => __(ucfirst(str_replace('_', ' ', 'birth_date'))),
            // 'birth_county'=>__(ucfirst(str_replace('_', ' ', 'birth_county'))),
            'birth_parish' => __(ucfirst(str_replace('_', ' ', 'birth_parish'))),
            'birth_province' => __(ucfirst(str_replace('_', ' ', 'birth_province'))),
            'immigration_date' => __(ucfirst(str_replace('_', ' ', 'immigration_date'))),
            'gender' => __(ucfirst(str_replace('_', ' ', 'gender'))),
            'civil_status' => __(ucfirst(str_replace('_', ' ', 'civil_status'))),
            // 'emigration_parish'=>__(ucfirst(str_replace('_', ' ', 'emigration_parish'))),
            // 'emigration_province'=>__(ucfirst(str_replace('_', ' ', 'emigration_province'))),
            'arrival_date_this_place' => __(ucfirst(str_replace('_', ' ', 'arrival_date_this_place'))),
            'arrived_from_place' => __(ucfirst(str_replace('_', ' ', 'arrived_from_place'))),
            'arrived_from_county' => __(ucfirst(str_replace('_', ' ', 'arrived_from_county'))),
            'arrived_from_state' => __(ucfirst(str_replace('_', ' ', 'arrived_from_state'))),
            'death_date' => __(ucfirst(str_replace('_', ' ', 'death_date'))),
            // 'family_nr'=>__(ucfirst(str_replace('_', ' ', 'family_nr'))),
            'source' => __(ucfirst(str_replace('_', ' ', 'source'))),
            'immigrated_to_place' => __(ucfirst(str_replace('_', ' ', 'immigrated_to_place'))),
            'immigrated_to_state' => __(ucfirst(str_replace('_', ' ', 'immigrated_to_state'))),
            'old_id' => __(ucfirst(str_replace('_', ' ', 'old_id'))),
            // 'birth_year'=>__(ucfirst(str_replace('_', ' ', 'birth_year'))),
            // 'birth_month'=>__(ucfirst(str_replace('_', ' ', 'birth_month'))),
            // 'birth_day'=>__(ucfirst(str_replace('_', ' ', 'birth_day'))),
            // 'immigration_year'=>__(ucfirst(str_replace('_', ' ', 'immigration_year'))),
            // 'immigration_month'=>__(ucfirst(str_replace('_', ' ', 'immigration_month'))),
            // 'immigration_day'=>__(ucfirst(str_replace('_', ' ', 'immigration_day'))),
            // 'death_year'=>__(ucfirst(str_replace('_', ' ', 'death_year'))),
            // 'death_month'=>__(ucfirst(str_replace('_', ' ', 'death_month'))),
            // 'death_day'=>__(ucfirst(str_replace('_', ' ', 'death_day'))),
            'page' => __(ucfirst(str_replace('_', ' ', 'page'))),

            // 'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id' => 'id',
            'archive_id' => __(ucfirst(str_replace('_', ' ', "archive_id"))),
        ];
    }

    /**
     * Get the archive associated with the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    /**
     * Get the searchable array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            // 'last_name2'=> $this->last_name2,
            'gender' => $this->gender,
            'civil_status' => $this->civil_status,
            'birth_parish' => $this->birth_parish,
            'birth_province' => $this->birth_province,
            'emigration_parish' => $this->emigration_parish,
            'emigration_province' => $this->emigration_province,
            'arrived_from_place' => $this->arrived_from_place,
            'arrived_from_county' => $this->arrived_from_county,
            'arrived_from_state' => $this->arrived_from_state,
            'immigrated_to_place' => $this->immigrated_to_place,
            'immigrated_to_state' => $this->immigrated_to_state,
            'birth_date' => $this->birth_date,
            'birth_year' => $this->birth_year,
            'death_year' => $this->death_year,
            'immigration_date' => $this->immigration_date,
            'immigration_year' => $this->immigration_year,
        ];
    }

    /**
     * Get the default search fields.
     *
     * @return array
     */
    public function defaultSearchFields()
    {
        return [
             'first_name',
             'last_name',
            'birth_date',
            '---',
            'birth_parish',
            'birth_province',
            '---',
            'gender',
            'civil_status',
            'family_nr',
            'arrival_date_this_place',
            '---',
            'immigration_date',
            'emigration_parish',
            'emigration_province',
            'immigrated_to_place',
            'immigrated_to_state',
            // ['emigration_province',
            // 'emigration_parish'],
            'source',
            'page',
            'death_date',
            'id',
        ];
    }

    /**
     * Get the advanced search fields.
     *
     * @return array
     */
    public function advancedSearchFields()
    {
        return [
            'civil_status',
            'family_nr',
            'arrived_from_place',
            'death_date',
            'source',
            'immigrated_to_place',
            'immigrated_to_state',
            'page',
        ];
    }

    /**
     * Get the default table columns.
     *
     * @return array
     */
    public function defaultTableColumns()
    {
        return [
            // 'first_name',
            // 'last_name',
            'birth_date',
            'birth_parish',
            'birth_province',
            'arrival_date_this_place',
            'emigration_parish',
            'emigration_province',
        ];
    }

    /**
     * Get the formatted birth date attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Get the user associated with the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the fields that should be matched during the query.
     *
     * @return array
     */
    public function enableQueryMatch()
    {
        return [
            'first_name',
            'last_name',
        ];

        return [];
    }

    /**
     * Get the additional search fields.
     *
     * @return array
     */
    public function searchFields()
    {
        return [

        ];
    }
}
