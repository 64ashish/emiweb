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


    public function defaultSearchFields()
    {
        return [
//            'first_name',
//            'last_name',
            "title",
            "time_period",
            "state",
            "county",
            "city"
        ];
    }

    public function defaultTableColumns(){
        return [
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
}
