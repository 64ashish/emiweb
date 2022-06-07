<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishAmericanChurchArchiveRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'last_name2'=> $this->last_name2,
            'gender'=> $this->gender,
            'civil_status'=> $this->civil_status,
            'birth_parish'=> $this->birth_parish,
            'birth_province'=> $this->birth_province,
            'emigration_parish'=> $this->emigration_parish,
            'emigration_province'=> $this->emigration_province,
            'arrived_from_place'=> $this->arrived_from_place,
            'arrived_from_county'=> $this->arrived_from_county,
            'arrived_from_state'=> $this->arrived_from_state,
            'immigrated_to_place'=> $this->immigrated_to_place,
            'immigrated_to_state'=> $this->immigrated_to_state,
            'birth_date' => $this->birth_date,
            'birth_year' => $this->birth_year,
            'death_year' => $this->death_year,
            'immigration_date' => $this->immigration_date,
            'immigration_year' => $this->immigration_year
        ];
    }
}
