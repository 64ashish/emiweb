<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class LarssonEmigrantPopularRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultSearchFields(){
        return [
//            'first_name',
//            'last_name',
            'profession',
            'home_location',
            'home_parish',
            'home_province',
        ];
    }

    public function defaultTableColumns(){
        return [
            'profession',
            'home_location',
            'home_parish',
            'home_province',
            'letter_date',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
