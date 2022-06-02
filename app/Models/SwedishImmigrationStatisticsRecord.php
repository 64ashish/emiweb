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
}
