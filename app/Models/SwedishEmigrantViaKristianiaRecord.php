<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishEmigrantViaKristianiaRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'profession',
        'age',
        'home_location',
        'agent',
        'destination',
        'ship',
        'departure_date',
        'cash',
        'payed_amount',
        'traveling_companion',
        'source_code',
        'constructed',
        'page_nr',
        'row_nr',
    ];

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
            'profession',
            'home_location',
            'destination',
            'departure_date',
        ];
    }

    public function defaultTableColumns(){
        return [
            'profession',
            'age',
            'home_location',
            'agent',
            'destination',
            'departure_date',
        ];
    }

}
