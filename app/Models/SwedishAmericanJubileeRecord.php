<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwedishAmericanJubileeRecord extends Model
{
    use HasFactory;

    protected $fillable = [
            "title",
            "remarks",
            "time_period",
            "state",
            "county",
            "city",
            "source",
            "page",
            "file_name",
            "description",
            "emi_web_lan",
            "emi_web_forsamling",
            "emi_web_emigration_year",
            "emi_web_akt_nr",
            "date_created",
            "file_format",
            "resolution",
            "secrecy"
    ];

    public function fieldsToDisply()
    {
        return [
            "title"=>__(ucfirst(str_replace('_', ' ', "title"))),
            "remarks"=>__(ucfirst(str_replace('_', ' ', "remarks"))),
            "time_period"=>__(ucfirst(str_replace('_', ' ', "time_period"))),
            "state"=>__(ucfirst(str_replace('_', ' ', "state"))),
            "county"=>__(ucfirst(str_replace('_', ' ', "county"))),
            "city"=>__(ucfirst(str_replace('_', ' ', "city"))),
            "source"=>__(ucfirst(str_replace('_', ' ', "source"))),
            "page"=>__(ucfirst(str_replace('_', ' ', "page"))),
            "file_name"=>__(ucfirst(str_replace('_', ' ', "file_name"))),
            "description"=>__(ucfirst(str_replace('_', ' ', "description"))),
            "emi_web_lan"=>__(ucfirst(str_replace('_', ' ', "emi_web_lan"))),
            "emi_web_forsamling"=>__(ucfirst(str_replace('_', ' ', "emi_web_forsamling"))),
            "emi_web_emigration_year"=>__(ucfirst(str_replace('_', ' ', "emi_web_emigration_year"))),
            "emi_web_akt_nr"=>__(ucfirst(str_replace('_', ' ', "emi_web_akt_nr"))),
            "date_created"=>__(ucfirst(str_replace('_', ' ', "date_created"))),
            "file_format"=>__(ucfirst(str_replace('_', ' ', "file_format"))),
            "resolution"=>__(ucfirst(str_replace('_', ' ', "resolution"))),
            "secrecy"=>__(ucfirst(str_replace('_', ' ', "secrecy"))),

//            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name' ))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }


    public function defaultSearchFields()
    {
        return [
            "title",
            "time_period",
            "state",
            "county",
            "city"
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            "title",
            "state",
            "county",
            "city",
            "source",
            "file_name"
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
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
