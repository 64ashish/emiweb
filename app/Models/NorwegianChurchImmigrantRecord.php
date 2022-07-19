<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorwegianChurchImmigrantRecord extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultTableColumns(){
        return [
            'sex',
            'profession',
            'from_country',
            'to_location',
            'birth_location',
            'baptism_location',
        ];
    }
}
