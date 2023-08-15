<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class LarssonEmigrantPopularRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'last_name',
        'first_name',
        'profession',
        'home_location',
        'home_parish',
        'home_province',
        'source_code',
        'letter_date',
        'notes'
    ];


    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name' ))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name' ))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession' ))),
            'home_location'=>__(ucfirst(str_replace('_', ' ', 'home_location' ))),
            'home_parish'=>__(ucfirst(str_replace('_', ' ', 'home_parish' ))),
            'home_province'=>__(ucfirst(str_replace('_', ' ', 'home_province' ))),
            'source_code'=>__(ucfirst(str_replace('_', ' ', 'source_code' ))),
            'letter_date'=>__(ucfirst(str_replace('_', ' ', 'letter_date' ))),
            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes' ))),
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

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'home_location',
            'home_parish',
            'profession',
            '---',
            'letter_date',
            'source_code',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'letter_date',
            'home_location',
            'home_parish',
            'profession',
            'source_code',
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
