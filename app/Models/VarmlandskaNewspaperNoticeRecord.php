<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class VarmlandskaNewspaperNoticeRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'newspaper',
        'article_year',
        'article_month',
        'article_day',
        'places',
        'death_parish',
        'death_country',
        'notes',
        'archive_reference',
        'file_name',
        'type',
        'birth_year',
        'birth_month',
        'birth_day',
        'death_year',
        'death_month',
        'death_day',
        'birth_location'
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
            'newspaper',
            'article_year',
            'places',
            'death_parish',
            'death_country',
            'birth_location'
        ];
    }
}
