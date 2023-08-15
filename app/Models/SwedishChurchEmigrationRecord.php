<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class SwedishChurchEmigrationRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $hidden = [''];

    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'gender',
        'from_province',
        'profession',
        'from_location',
        'from_parish',
        'civil_status',
        'birth_parish',
        'birth_province',
        'has_family',
        'record_date',
        'destination_country',
        'secrecy',
        'main_act',
        'act_number',
        'household_examination_volume',
        'emigration_book_volume',
        'emigration_book_note',
        'immigration_note',
        'immigration_date',
        'work_certificate_note',
        'memo',
        'year_act_number',
        'supplement_reference',
        'number_in_emigration_book',
        'before_parish',
        'before_province',
        'before_location',
        'before_country',
        'before_year',
        'father_last_name',
        'father_first_name',
        'father_profession',
        'mother_last_name',
        'mother_first_name',
        'mother_profession',
        'partner_last_name',
        'partner_first_name',
        'partner_profession',
        'birth_location_in_parish',
        'source',
        'notes',
        'birth_location',
        'birth_country',
        'farm_name',
        'page_in_original',
        'country_code',
        'destination_location',
        'source_hfl_batch_number',
        'source_hfl_image_number',
        'source_in_out_batch_number',
        'source_in_out_image_number'
    ];

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

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'dob',
            '---',
            ['birth_province',
            'birth_parish'],
            'birth_country',
            '---',
            'record_date',
            'from_location',
            ['from_province',
            'from_parish'],
            '---',
            'destination_country',
            'country_code',
            'destination_location',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'dob',
            'birth_parish',
            // 'gender',
//            'last_resident',
            
//            'birth_place',
            
            'record_date',
            'from_province',
            // 'destination_country',
//            'before_location',
//            'before_country'
        ];
    }

    public function searchFields(){
        return [
            'profession',
            'gender',
            'civil_status',
            'has_family',
            'birth_location',
            'birth_location_in_parish',
            '---',
            'main_act',
            'act_number',
            'year_act_number',
            '---',
            'memo',
            'notes',
            'supplement_reference',
            'work_certificate_note',
            'number_in_emigration_book',
            '---',
            'farm_name',
            'father_last_name',
            'father_first_name',
            'father_profession',
            'mother_last_name',
            'mother_first_name',
            'mother_profession',
            'partner_last_name',
            'partner_first_name',
            'partner_profession',
            '---',
            'before_year',
            'before_location',
            'before_parish',
            'before_province',
            'before_country',
            'immigration_note',
            'immigration_date',
            '---',
            'source',
            'household_examination_volume',
            'page_in_original',
            'emigration_book_volume',
            'emigration_book_note',
            'source_hfl_batch_number',
            'source_hfl_image_number',
            'source_in_out_batch_number',
            'source_in_out_image_number',
            'secrecy',
        ];
    }

    public function dob(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->is('01-01') ? Carbon::parse($value)->format('Y') :
                Carbon::parse($value)->format('Y-m-d')
        );
    }

    public function recordDate(): Attribute
    {
        return new Attribute(
            get: fn($value) => Carbon::parse($value)->is('01-01') ? Carbon::parse($value)->format('Y') :
                Carbon::parse($value)->format('Y-m-d')
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function photo(){
        return $this->hasOne(ScercPhotoRecord::class,'scerc_id');
    }

    public function document()
    {
        return $this->hasOne(ScercDocumentRecord::class,'scerc_id');
    }

    public function fieldsToDisply(){
        return [
            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))) ,
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))) ,
            'dob'=>__(ucfirst(str_replace('_', ' ', 'dob'))),
            'gender'=>__(ucfirst(str_replace('_', ' ', 'gender'))) ,
            'last_resident'=>__(ucfirst(str_replace('_', ' ', 'last_resident'))) ,
            'from_province'=>__(ucfirst(str_replace('_', ' ', 'from_province'))) ,
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))) ,
            'from_location'=>__(ucfirst(str_replace('_', ' ', 'from_location'))) ,
            'from_parish'=>__(ucfirst(str_replace('_', ' ', 'from_parish'))) ,
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))) ,
            'birth_parish'=>__(ucfirst(str_replace('_', ' ', 'birth_parish'))) ,
            'birth_province'=>__(ucfirst(str_replace('_', ' ', 'birth_province'))) ,
            'has_family'=>__(ucfirst(str_replace('_', ' ', 'has_family'))) ,
            'record_date'=>__(ucfirst(str_replace('_', ' ', 'record_date'))) ,
            'destination_country'=>__(ucfirst(str_replace('_', ' ', 'destination_country'))) ,
            'secrecy'=>__(ucfirst(str_replace('_', ' ', 'secrecy'))) ,
            'main_act'=>__(ucfirst(str_replace('_', ' ', 'main_act'))) ,
            'act_number'=>__(ucfirst(str_replace('_', ' ', 'act_number'))) ,
            'household_examination_volume'=>__(ucfirst(str_replace('_', ' ', 'household_examination_volume'))) ,
            'emigration_book_volume'=>__(ucfirst(str_replace('_', ' ', 'emigration_book_volume'))) ,
            'emigration_book_note'=>__(ucfirst(str_replace('_', ' ', 'emigration_book_note'))) ,
            'immigration_note'=>__(ucfirst(str_replace('_', ' ', 'immigration_note'))) ,
            'immigration_date'=>__(ucfirst(str_replace('_', ' ', 'immigration_date'))) ,
            'work_certificate_note'=>__(ucfirst(str_replace('_', ' ', 'work_certificate_note'))) ,
            'memo'=>__(ucfirst(str_replace('_', ' ', 'memo'))) ,
            'year_act_number'=>__(ucfirst(str_replace('_', ' ', 'year_act_number'))) ,
            'supplement_reference'=>__(ucfirst(str_replace('_', ' ', 'supplement_reference'))) ,
            'number_in_emigration_book'=>__(ucfirst(str_replace('_', ' ', 'number_in_emigration_book'))) ,
            'before_parish'=>__(ucfirst(str_replace('_', ' ', 'before_parish'))) ,
            'before_province'=>__(ucfirst(str_replace('_', ' ', 'before_province'))) ,
            'before_location'=>__(ucfirst(str_replace('_', ' ', 'before_location'))) ,
            'before_country'=>__(ucfirst(str_replace('_', ' ', 'before_country'))) ,
            'before_year'=>__(ucfirst(str_replace('_', ' ', 'before_year'))) ,
            'father_last_name'=>__(ucfirst(str_replace('_', ' ', 'father_last_name'))) ,
            'father_first_name'=>__(ucfirst(str_replace('_', ' ', 'father_first_name'))) ,
            'father_profession'=>__(ucfirst(str_replace('_', ' ', 'father_profession'))) ,
            'mother_last_name'=>__(ucfirst(str_replace('_', ' ', 'mother_last_name'))) ,
            'mother_first_name'=>__(ucfirst(str_replace('_', ' ', 'mother_first_name'))) ,
            'mother_profession'=>__(ucfirst(str_replace('_', ' ', 'mother_profession'))) ,
            'partner_last_name'=>__(ucfirst(str_replace('_', ' ', 'partner_last_name'))) ,
            'partner_first_name'=>__(ucfirst(str_replace('_', ' ', 'partner_first_name'))) ,
            'partner_profession'=>__(ucfirst(str_replace('_', ' ', 'partner_profession'))) ,
            'birth_location_in_parish'=>__(ucfirst(str_replace('_', ' ', 'birth_location_in_parish'))) ,
            'source'=>__(ucfirst(str_replace('_', ' ', 'source'))) ,
            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes'))) ,
            'birth_location'=>__(ucfirst(str_replace('_', ' ', 'birth_location'))) ,
            'birth_country'=>__(ucfirst(str_replace('_', ' ', 'birth_country'))) ,
            'farm_name'=>__(ucfirst(str_replace('_', ' ', 'farm_name'))) ,
            'page_in_original'=>__(ucfirst(str_replace('_', ' ', 'page_in_original'))) ,
            'country_code'=>__(ucfirst(str_replace('_', ' ', 'country_code'))) ,
            'destination_location'=>__(ucfirst(str_replace('_', ' ', 'destination_location'))) ,
            'source_hfl_batch_number'=>__(ucfirst(str_replace('_', ' ', 'source_hfl_batch_number'))) ,
            'source_hfl_image_number'=>__(ucfirst(str_replace('_', ' ', 'source_hfl_image_number'))) ,
            'source_in_out_batch_number'=>__(ucfirst(str_replace('_', ' ', 'source_in_out_batch_number'))) ,
            'source_in_out_image_number'=>__(ucfirst(str_replace('_', ' ', 'source_in_out_image_number'))) ,
            'id' =>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }
//    scopes for filter
    public function scopeFindGender($query, $gender){
        if($gender === "Män") { return $query->where('gender', 'M'); }
        if($gender === "Kvinnor") { return $query->where('gender', 'K'); }
        return $query;
    }

    public function scopeRecordDateRange($query, $start_year, $end_year){

//        if only start date is given
        if($start_year != null and $end_year == null){
            return $query->whereNotNull(DB::raw('YEAR(record_date)'))
                ->where(DB::raw('YEAR(record_date)'), $start_year);
        }
        if(($start_year != null and $end_year != null) and ($start_year < $end_year )) {
            return  $query->whereNotNull(DB::raw('YEAR(record_date)'))
                ->whereBetween(DB::raw('YEAR(record_date)'),[$start_year, $end_year]);
        }

        return $query;
    }

    public function scopeFromProvince($query, $from_province){
        if($from_province !== "0") { return $query->where('from_province', $from_province); }
        return $query;
    }

    public function scopeFromParish($query, $from_parish){
        if($from_parish) { return $query->where('from_parish', $from_parish); }
        return $query;
    }

    public function scopeGroupRecordsBy($query, $group_by){
        if($group_by === "record_date") {
            return $query->select(DB::raw('YEAR(record_date) as year'),DB::raw('COUNT(*) as total'))
                ->groupByRaw('YEAR(record_date)')
                ->orderByDesc('year');
        }

        if($group_by === "from_provinces") {
            return $query->whereNot('from_province', '0')
                ->select('from_province',DB::raw("COUNT(*) as total") )
                ->groupByRaw('from_province');
        }

        return $query;
    }

    public function enableQueryMatch(){
        return [
            'first_name',
            'last_name',
            'destination_country',
            'destination_location',
            'birth_country'
        ];
    }







}
