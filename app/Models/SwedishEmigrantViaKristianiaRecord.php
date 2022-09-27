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

    public function fieldsToDisply()
    {
        return [
            'first_name' =>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name' =>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'profession' =>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'age' =>__(ucfirst(str_replace('_', ' ', 'age'))),
            'home_location' =>__(ucfirst(str_replace('_', ' ', 'home_location'))),
            'agent' =>__(ucfirst(str_replace('_', ' ', 'agent'))),
            'destination' =>__(ucfirst(str_replace('_', ' ', 'destination'))),
            'ship' =>__(ucfirst(str_replace('_', ' ', 'ship'))),
            'departure_date' =>__(ucfirst(str_replace('_', ' ', 'departure_date'))),
            'cash' =>__(ucfirst(str_replace('_', ' ', 'cash'))),
            'payed_amount' =>__(ucfirst(str_replace('_', ' ', 'payed_amount'))),
            'traveling_companion' =>__(ucfirst(str_replace('_', ' ', 'traveling_companion'))),
            'source_code' =>__(ucfirst(str_replace('_', ' ', 'source_code'))),
            'constructed' =>__(ucfirst(str_replace('_', ' ', 'constructed'))),
            'page_nr' =>__(ucfirst(str_replace('_', ' ', 'page_nr'))),
            'row_nr' =>__(ucfirst(str_replace('_', ' ', 'row_nr'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
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
//            'first_name',
//            'last_name',
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

    public function user(){
        return $this->belongsTo(User::class);
    }

}
