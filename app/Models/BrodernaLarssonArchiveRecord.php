<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

class BrodernaLarssonArchiveRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'home_location',
        'home_parish',
        'home_county',
        'home_country',
        'letter_date',
        'gender',
        'profession',
        'geographical_extent',
        'archive_reference',
        'source_code',
        'archives_name',
        'created_by',
        'language',
        'key_words',
        'type',
        'format',
        'number_of_pages',
        'file_name',
        'comments',
    ];

    public function fieldsToDisply()
    {
        return [
            'first_name' =>__(ucfirst(str_replace('_', ' ','first_name' ))),
            'last_name' =>__(ucfirst(str_replace('_', ' ','last_name' ))),
            'home_location' =>__(ucfirst(str_replace('_', ' ','home_location' ))),
            'home_parish' =>__(ucfirst(str_replace('_', ' ','home_parish' ))),
            'home_county' =>__(ucfirst(str_replace('_', ' ','home_county' ))),
            'home_country' =>__(ucfirst(str_replace('_', ' ','home_country' ))),
            'letter_date' =>__(ucfirst(str_replace('_', ' ','letter_date' ))),
            'gender' =>__(ucfirst(str_replace('_', ' ','gender' ))),
            'profession' =>__(ucfirst(str_replace('_', ' ','profession' ))),
            'geographical_extent' =>__(ucfirst(str_replace('_', ' ','geographical_extent' ))),
            'archive_reference' =>__(ucfirst(str_replace('_', ' ','archive_reference' ))),
            'source_code' =>__(ucfirst(str_replace('_', ' ','source_code' ))),
            'archives_name' =>__(ucfirst(str_replace('_', ' ','archives_name' ))),
            'created_by' =>__(ucfirst(str_replace('_', ' ','created_by' ))),
            'language' =>__(ucfirst(str_replace('_', ' ','language' ))),
            'key_words' =>__(ucfirst(str_replace('_', ' ','key_words' ))),
            'type' =>__(ucfirst(str_replace('_', ' ','type' ))),
            'format' =>__(ucfirst(str_replace('_', ' ','format' ))),
            'number_of_pages' =>__(ucfirst(str_replace('_', ' ','number_of_pages' ))),
            'file_name' =>__(ucfirst(str_replace('_', ' ','file_name' ))),
            'comments' =>__(ucfirst(str_replace('_', ' ','comments' ))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }




    public function Archive()
    {
        return $this->belongsTo(Archive::class);
    }



    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'home_location' => $this->home_location,
            'home_parish' => $this->home_parish,
            'home_county' => $this->home_county,
            'home_country' => $this->home_country,
            'letter_date' => $this->letter_date,
            'gender' => $this->gender,
            'profession' => $this->profession,
            'geographical_extent' => $this->geographical_extent,
            'archive_reference' => $this->archive_reference,
            'source_code' => $this->source_code,
            'archive_name' => $this->archive_name,
            ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'home_location',
            'home_parish',
            'home_county',
            'home_country',
            'gender',
            'profession',
            'letter_date'
        ];
    }

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'home_location',
            ['home_county',
            'home_parish'],
            'profession',
            'letter_date',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function enableQueryMatch(){
        return [
            'first_name',
            'last_name',
        ];
    }

//    public function searchFields()
//    {
//        return [];
//    }

    public function searchFields()
    {
        return [
            'source_code',
            'geographical_extent',
        ];
    }

}
