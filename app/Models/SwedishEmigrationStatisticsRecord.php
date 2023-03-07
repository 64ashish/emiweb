<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishEmigrationStatisticsRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'first_name',
        'last_name',
        'birth_year',
        'profession',
        'from_parish',
        'from_province',
        'from_year',
        'destination',
        'gender',
        'civil_status',
        'nationality',
        'family_number',
        'source',
        'comments',
        'birth_month',
        'birth_day',
        'svar_batch_number',
        'svar_image_number'
    ];



    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'birth_year'=>__(ucfirst(str_replace('_', ' ', 'birth_year'))),
            'birth_month'=>__(ucfirst(str_replace('_', ' ', 'birth_month'))),
            'birth_day'=>__(ucfirst(str_replace('_', ' ', 'birth_day'))),
            'destination'=>__(ucfirst(str_replace('_', ' ', 'destination'))),
            'comments'=>__(ucfirst(str_replace('_', ' ', 'comments'))),
            'from_year'=>__(ucfirst(str_replace('_', ' ', 'from_year'))),
            'from_province'=>__(ucfirst(str_replace('_', ' ', 'from_province'))),
            'from_parish'=>__(ucfirst(str_replace('_', ' ', 'from_parish'))),
            'gender'=>__(ucfirst(str_replace('_', ' ', 'gender'))),
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'family_number'=>__(ucfirst(str_replace('_', ' ', 'family_number'))),
            'nationality'=>__(ucfirst(str_replace('_', ' ', 'nationality'))),
            'source'=>__(ucfirst(str_replace('_', ' ', 'source'))),
            'svar_batch_number'=>__(ucfirst(str_replace('_', ' ', 'svar_batch_number'))),
            'svar_image_number'=>__(ucfirst(str_replace('_', ' ', 'svar_image_number'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
    public function defaultSearchFields()
    {
        return [
            'first_name',
            'last_name',
            ['birth_year',
            'birth_month',
            'birth_day'],
            'profession',
            '---',
            ['from_province',
            'from_parish'],
            'from_year',
            'nationality',

        ];
    }

    public function advancedSearchFields(){
        return [
            'gender',
            'civil_status',
            'nationality',
            'family_number',
            'source',
            'comments',
            'birth_month',
            'birth_day',
            'svar_batch_number',
            'svar_image_number'
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

        public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'from_province' => $this->from_province,
            'from_parish' => $this->from_parish,
            'last_resident' => $this->last_resident,
            'profession' => $this->profession,
            'destination' => $this->destination,
            'birth_year' => $this->birth_year,
            'civil_status' => $this->civil_status,
            'from_year' => $this->from_year,
            'nationality' => $this->nationality
            ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'profession',
            'destination',
            'from_province',
            'gender',
            'civil_status',
            'nationality',
        ];
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
