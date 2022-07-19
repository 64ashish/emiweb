<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishImmigrationStatisticsRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'profession',
        'last_name',
        'birth_year',
        'birth_month',
        'birth_day',
        'from_country',
        'comments',
        'family_nr',
        'nationality',
        'source',
        'sex',
        'civil_status',
        'svar_batch_nr',
        'svar_image_nr',
        'to_year',
        'to_province',
        'to_parish'
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
            'profession' => $this->profession,
            'last_name' => $this->last_name,
            'from_country' => $this->from_country,
            'comments' => $this->comments,
            'nationality' => $this->nationality,
            'source' => $this->source,
            'civil_status' => $this->civil_status,
            'to_province' => $this->to_province,
            'to_parish' => $this->to_parish,
            'birth_year' => $this->birth_year,
            'sex' => $this->sex,
            'to_year' => $this->to_year,
        ];
    }

    public function defaultTableColumns(){
        return [ 'profession',
            'birth_year',
            'from_country',
            'nationality',
            'civil_status',
            'to_year',
            'to_province',];
    }


}
