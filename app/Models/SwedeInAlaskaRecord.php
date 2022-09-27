<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
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



    public function fieldsToDisply()
    {
        return [
            'first_name' =>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name' =>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_location' =>__(ucfirst(str_replace('_', ' ', 'birth_location'))),
            'birth_country' =>__(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'birth_date' =>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'gender' =>__(ucfirst(str_replace('_', ' ', 'gender'))),
            'father_first_name' =>__(ucfirst(str_replace('_', ' ', 'father_first_name'))),
            'father_last_name' =>__(ucfirst(str_replace('_', ' ', 'father_last_name'))),
            'father_birth_location' =>__(ucfirst(str_replace('_', ' ', 'father_birth_location'))),
            'father_birth_country' =>__(ucfirst(str_replace('_', ' ', 'father_birth_country'))),
            'mother_first_name' =>__(ucfirst(str_replace('_', ' ', 'mother_first_name'))),
            'mother_last_name' =>__(ucfirst(str_replace('_', ' ', 'mother_last_name'))),
            'mother_birth_location' =>__(ucfirst(str_replace('_', ' ', 'mother_birth_location'))),
            'mother_birth_country' =>__(ucfirst(str_replace('_', ' ', 'mother_birth_country'))),
            'to_america_date' =>__(ucfirst(str_replace('_', ' ', 'to_america_date'))),
            'to_america_location' =>__(ucfirst(str_replace('_', ' ', 'to_america_location'))),
            'arrival_date_alaska' =>__(ucfirst(str_replace('_', ' ', 'arrival_date_alaska'))),
            'arrival_location_alaska' =>__(ucfirst(str_replace('_', ' ', 'arrival_location_alaska'))),
            'profession' =>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'address' =>__(ucfirst(str_replace('_', ' ', 'address'))),
            'postal_address' =>__(ucfirst(str_replace('_', ' ', 'postal_address'))),
            'civil_status' =>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'partner_last_name' =>__(ucfirst(str_replace('_', ' ', 'partner_last_name'))),
            'partner_first_name' =>__(ucfirst(str_replace('_', ' ', 'partner_first_name'))),
            'partner_birth_date' =>__(ucfirst(str_replace('_', ' ', 'partner_birth_date'))),
            'partner_birth_location' =>__(ucfirst(str_replace('_', ' ', 'partner_birth_location'))),
            'partner_birth_country' =>__(ucfirst(str_replace('_', ' ', 'partner_birth_country'))),
            'partner_profession' =>__(ucfirst(str_replace('_', ' ', 'partner_profession'))),
            'number_of_children' =>__(ucfirst(str_replace('_', ' ', 'number_of_children'))),
            'children_first_name' =>__(ucfirst(str_replace('_', ' ', 'children_first_name'))),
            'children_address' =>__(ucfirst(str_replace('_', ' ', 'children_address'))),
            'children_postal_address' =>__(ucfirst(str_replace('_', ' ', 'children_postal_address'))),
            'other_relative1_relationship' =>__(ucfirst(str_replace('_', ' ', 'other_relative1_relationship'))),
            'other_relative1_name' =>__(ucfirst(str_replace('_', ' ', 'other_relative1_name'))),
            'other_relative1_address' =>__(ucfirst(str_replace('_', ' ', 'other_relative1_address'))),
            'other_relative1_postal_address' =>__(ucfirst(str_replace('_', ' ', 'other_relative1_postal_address'))),
            'other_relative2_relationship' =>__(ucfirst(str_replace('_', ' ', 'other_relative2_relationship'))),
            'other_relative2_name' =>__(ucfirst(str_replace('_', ' ', 'other_relative2_name'))),
            'other_relative2_address' =>__(ucfirst(str_replace('_', ' ', 'other_relative2_address'))),
            'other_relative2_postal_address' =>__(ucfirst(str_replace('_', ' ', 'other_relative2_postal_address'))),
            'death_date' =>__(ucfirst(str_replace('_', ' ', 'death_date'))),
            'death_location' =>__(ucfirst(str_replace('_', ' ', 'death_location'))),
            'source' =>__(ucfirst(str_replace('_', ' ', 'source'))),
            'comments' =>__(ucfirst(str_replace('_', ' ', 'comments'))),

//            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    /**public function archive()
    {
    return $this->belongsTo(Archive::class);
    }
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */


    public function defaultSearchFields()
    {
        return [
//            'first_name',
//            'last_name',
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
    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
