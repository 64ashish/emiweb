<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MormonShipPassengerRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'nationality',
        'residence',
        'residence_country',
        'ship_name',
        'profession',
        'comments',
        'family_nr',
        'birth_place',
        'birth_country',
        'age',
        'conference',
        'travel_type',
        'departure_year',
        'departure_month',
        'departure_day',
        'destination',
        'dgsnr',
        'image_nr',
        'gsnumber',
        'gender',
        'entry',
        'inclusive_dates',
        'libr_no',
        'volume_nr',

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
            'nationality',
            'residence',
            'residence_country',
            'birth_place',
            'birth_country',
            'departure_year',
            'destination',
            'gender',
        ];
    }

    public function defaultTableColumns(){
        return [
            'nationality',
            'residence',
            'residence_country',
            'profession',
            'destination',
            'gender',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
