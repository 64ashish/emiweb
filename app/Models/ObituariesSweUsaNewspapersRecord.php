<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ObituariesSweUsaNewspapersRecord extends Model
{
    use HasFactory, RecordCount;

    protected $fillable = [
        'first_name',
        'last_name',
        'death_location',
        'death_state',
        'death_date',
        'age_year',
        'age_month',
        'age_day',
        'location_in_sweden',
        'county_in_sweden',
        'arrival_year',
        'birth_date',
        'svam_newspaper_id',
        'source_date',
        'comments',
        'from_parish',
        'from_province',
        'from_year',
        'act_nr',
        'file_name'
    ];

    public function archive(){
        return $this->belongsTo(Archive::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function scopeFromProvince($query, $from_province){
        if($from_province !== "0") { return $query->where('from_province', $from_province); }
        return $query;
    }

    public function scopeFromParish($query, $from_parish){
        if($from_parish) { return $query->where('from_parish', $from_parish); }
        return $query;
    }


    public function defaultSearchFields()
    {
        return [
            'first_name',
            'last_name',
            'death_location',
            'death_state',
            'death_date',
            'from_province',
            'from_parish',
            '---',
            'birth_date',
            'location_in_sweden',
            'county_in_sweden',
            'from_year',
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

    public function fieldsToDisply()
    {
        return [
            'first_name' =>__(ucfirst(str_replace('_',' ','first_name'))),
            'last_name' =>__(ucfirst(str_replace('_',' ','last_name'))),
            'death_location' =>__(ucfirst(str_replace('_',' ','death_location'))),
            'death_state' =>__(ucfirst(str_replace('_',' ','death_state'))),
            'death_date' =>__(ucfirst(str_replace('_',' ','death_date'))),
            'age_year' =>__(ucfirst(str_replace('_',' ','age_year'))),
            'age_month' =>__(ucfirst(str_replace('_',' ','age_month'))),
            'age_day' =>__(ucfirst(str_replace('_',' ','age_day'))),
            'location_in_sweden' =>__(ucfirst(str_replace('_',' ','location_in_sweden'))),
            'county_in_sweden' =>__(ucfirst(str_replace('_',' ','county_in_sweden'))),
            'arrival_year' =>__(ucfirst(str_replace('_',' ','arrival_year'))),
            'birth_date' =>__(ucfirst(str_replace('_',' ','birth_date'))),
            'svam_newspaper_id' =>__(ucfirst(str_replace('_',' ','svam_newspaper_id'))),
            'source_date' =>__(ucfirst(str_replace('_',' ','source_date'))),
            'comments' =>__(ucfirst(str_replace('_',' ','comments'))),
            'from_parish' =>__(ucfirst(str_replace('_',' ','from_parish'))),
            'from_province' =>__(ucfirst(str_replace('_',' ','from_province'))),
            'from_year' =>__(ucfirst(str_replace('_',' ','from_year'))),
            'act_nr' =>__(ucfirst(str_replace('_',' ','act_nr'))),
            'file_name' =>__(ucfirst(str_replace('_',' ','file_name'))),
            'id' =>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
            ];
    }

    public function defaultTableColumns()
    {
        return [
            'birth_date',
            'location_in_sweden',
            'death_date',
            'death_location',
            'death_state',
            'from_year',
        ];
    }

}
