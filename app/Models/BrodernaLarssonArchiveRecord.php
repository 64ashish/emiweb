<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class BrodernaLarssonArchiveRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'home_location',
        'home_parish',
        'home_county',
        'home_country',
        'letter_date',
        'gender',
        'profession',
        'geographical_extent',
        'archive_reference',
        'source_code',
        'archive_name',
        'created_by',
        'language',
        'key_words',
        'type',
        'format',
        'number_of_pages',
        'file_name',
        'comments',
    ];

    public function Archive()
    {
        return $this->belongsTo(Archive::class);
    }


}
