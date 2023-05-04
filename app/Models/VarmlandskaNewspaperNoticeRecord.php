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

    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'newspaper'=>__(ucfirst(str_replace('_', ' ', 'newspaper'))),
            'article_year'=>__(ucfirst(str_replace('_', ' ', 'article_year'))),
            'article_month'=>__(ucfirst(str_replace('_', ' ', 'article_month'))),
            'article_day'=>__(ucfirst(str_replace('_', ' ', 'article_day'))),
            'places'=>__(ucfirst(str_replace('_', ' ', 'places'))),
            'death_parish'=>__(ucfirst(str_replace('_', ' ', 'death_parish'))),
            'death_country'=>__(ucfirst(str_replace('_', ' ', 'death_country'))),
            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes'))),
            'archive_reference'=>__(ucfirst(str_replace('_', ' ', 'archive_reference'))),
            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name'))),
            'type'=>__(ucfirst(str_replace('_', ' ', 'type'))),
            'birth_year'=>__(ucfirst(str_replace('_', ' ', 'birth_year'))),
            'birth_month'=>__(ucfirst(str_replace('_', ' ', 'birth_month'))),
            'birth_day'=>__(ucfirst(str_replace('_', ' ', 'birth_day'))),
            'death_year'=>__(ucfirst(str_replace('_', ' ', 'death_year'))),
            'death_month'=>__(ucfirst(str_replace('_', ' ', 'death_month'))),
            'death_day'=>__(ucfirst(str_replace('_', ' ', 'death_day'))),
            'birth_location'=>__(ucfirst(str_replace('_', ' ', 'birth_location'))),

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

    public function defaultSearchFields()
    {
        return [
            'first_name',
            'last_name',
            ['article_year',
                'article_month',
                'article_day'],
            'death_parish',
            'death_country',
            'places',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'newspaper',
            'article_year',
            'places',
            'death_parish',
            'death_country',
            'birth_location'
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

    public function searchFields()
    {
        return [

        ];
    }
}
