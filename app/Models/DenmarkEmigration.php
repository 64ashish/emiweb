<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class DenmarkEmigration extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'organization_id',
        'first_name',
        'last_name',
        'sex',
        'age',
        'birth_place',
        'last_resident',
        'profession',
        'destination_city',
        'destination_country',
        'ship_name',
        'traveled_on',
        'contract_number',
        'comment',
        'secrecy',
        'travel_type',
        'source',
        'dduid'
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
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'birth_place' => $this->birth_place,
            'last_resident' => $this->last_resident,
            'profession' => $this->profession,
            'destination_city' => $this->destination_city,
            'destination_country' => $this->destination_country,
            'ship_name' => $this->ship_name,
            ];
    }


    public function defaultSearchFields(){
        return [
//            'first_name',
//            'last_name',
            'sex',
            'birth_place',
            'profession',
            'destination_city',
            'destination_country'
        ];
    }


    public function defaultTableColumns(){
        return [
            'birth_place',
            'sex',
            'last_resident',
            'profession',
            'destination_city',
            'destination_country',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
