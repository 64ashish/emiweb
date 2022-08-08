<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishChurchEmigrationRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'first_name','last_name','dob','gender','last_resident','from_province','profession','birth_place',
        'civil_status','from_parish','birth_parish','hasFamily','record_date','destination_country','secrecy',
        'main_act','act_number','household_examination_volume','emigration_book_volume','emigration_book_note',
        'immigration_note','immigration_date','work_certificate_note','memo','year_act_number','supplement_reference','
        number_in_emigration_book','before_parish','before_province','before_location','before_country','before_year','
        father_last_name','father_first_name','father_profession','mother_last_name','mother_first_name',
        'mother_profession','partner_last_name','partner_first_name','partner_profession','birth_location_in_parish',
        'source','notes','birth_location','birth_country','farm_name','page_in_original','country_code',
        'destination_location','source_hfl_batch_number','source_hfl_image_number','source_in_out_batch_number',
        'source_in_out_image_number'];


    public function archive(){
        return $this->belongsTo(Archive::class);
    }

//    protected $dates = ['dob'];
    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'birth_place' => $this->birth_place,
            'last_resident' => $this->last_resident,
            'profession' => $this->profession,
            'destination_country' => $this->destination_country,
            'from_parish' => $this->from_parish,
            'act_number'=> $this->act_number,
            'dob'=> $this->dob,
            'from_province'=> $this->from_province,
            'record_date'=> $this->record_date
        ];
    }

    public function defaultTableColumns(){
        return [
            'dob',
            'gender',
            'last_resident',
            'from_province',
            'profession',
            'civil_status',
            'destination_country'
        ];
    }

//    public function getDobAttribute($value)
//    {
//        return Carbon::parse($value)->format('Y/m/d');
//    }
}
