<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedeInAlaskaRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
            'user_id',
            'archive_id',
            'first_name',
            'last_name',
            'birth_location',
            'birth_country',
            'birth_date',
            'gender',
            'father_first_name',
            'father_last_name',
            'father_birth_location',
            'father_birth_country',
            'mother_first_name',
            'mother_last_name',
            'mother_birth_location',
            'mother_birth_country',
            'to_america_date',
            'to_america_location',
            'arrival_date_alaska',
            'arrival_location_alaska',
            'profession',
            'address',
            'postal_address',
            'civil_status',
            'partner_last_name',
            'partner_first_name',
            'partner_birth_date',
            'partner_birth_location',
            'partner_birth_country',
            'partner_profession',
            'number_of_children',
            'children_first_name',
            'children_address',
            'children_postal_address',
            'other_relative1_relationship',
            'other_relative1_name',
            'other_relative1_address',
            'other_relative1_postal_address',
            'other_relative2_relationship',
            'other_relative2_name',
            'other_relative2_address',
            'other_relative2_postal_address',
            'death_date',
            'death_location',
            'source',
            'comments'
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
            'birth_location',
            'birth_country',
            'birth_date',
            'gender',
            'to_america_date',
            'to_america_location',
            'arrival_date_alaska',
            'arrival_location_alaska',
            'profession',
            'address',
        ];
    }

    public function defaultTableColumns(){
        return [
            'birth_location',
            'birth_country',
            'gender',
            'to_america_location',
            'arrival_date_alaska',
            'profession',
            'address',
            'civil_status',
        ];
    }
}
