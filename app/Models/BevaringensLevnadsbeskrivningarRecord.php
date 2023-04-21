<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BevaringensLevnadsbeskrivningarRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'archive_id',
        "first_name",
        "last_name",
        "company",
        "no_in_enrollment_length",
        "year_class",
        "no_for_roller_guidance_area",
        "letter_date",
        "date_of_birth",
        "place_of_birth",
        "residence_at_the_time_of_enrolment",
        "comments",
        "file_name",
        "source_reference",
        "picture_no",
        "education_level",
        "number_of_places_mentioned",
        "description_with_full_text",
        "born_outside_varmland",
        "family",
        "occupation_1",
        "occupation_2",
        "profession_3",
        "profession_4",
        "other_professions",
    ];

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function defaultSearchFields(){
        return [
            "first_name",
            "last_name",
            "place_of_birth",
            "date_of_birth",
            "residence_at_the_time_of_enrolment",
        ];
    }

    public function enableQueryMatch(){
        return [
            "first_name",
            "last_name",
            "place_of_birth",
            "residence_at_the_time_of_enrolment",
        ];
    }

    public function fieldsToDisply()
    {
        return [

            "first_name" => __(ucfirst(str_replace('_', ' ', 'first_name'))),
            "last_name" => __(ucfirst(str_replace('_', ' ', 'last_name'))),
            "company" => __(ucfirst(str_replace('_', ' ', 'company'))),
            "no_in_enrollment_length" => __(ucfirst(str_replace('_', ' ', 'no_in_enrollment_length'))),
            "year_class" => __(ucfirst(str_replace('_', ' ', 'year_class'))),
            "no_for_roller_guidance_area" => __(ucfirst(str_replace('_', ' ', 'no_for_roller_guidance_area'))),
            "letter_date" => __(ucfirst(str_replace('_', ' ', 'letter_date'))),
            "date_of_birth" => __(ucfirst(str_replace('_', ' ', 'date_of_birth'))),
            "place_of_birth" => __(ucfirst(str_replace('_', ' ', 'place_of_birth'))),
            "residence_at_the_time_of_enrolment" => __(ucfirst(str_replace('_', ' ', 'residence_at_the_time_of_enrolment'))),
            "comments" => __(ucfirst(str_replace('_', ' ', 'comments'))),
            "file_name" => __(ucfirst(str_replace('_', ' ', 'file_name'))),
            "source_reference" => __(ucfirst(str_replace('_', ' ', 'source_reference'))),
            "picture_no" => __(ucfirst(str_replace('_', ' ', 'picture_no'))),
            "education_level" => __(ucfirst(str_replace('_', ' ', 'education_level'))),
            "number_of_places_mentioned" => __(ucfirst(str_replace('_', ' ', 'number_of_places_mentioned'))),
            "description_with_full_text" => __(ucfirst(str_replace('_', ' ', 'description_with_full_text'))),
            "born_outside_varmland" => __(ucfirst(str_replace('_', ' ', 'born_outside_varmland'))),
            "family" => __(ucfirst(str_replace('_', ' ', 'family'))),
            "occupation_1" => __(ucfirst(str_replace('_', ' ', 'occupation_1'))),
            "occupation_2" => __(ucfirst(str_replace('_', ' ', 'occupation_2'))),
            "profession_3" => __(ucfirst(str_replace('_', ' ', 'profession_3'))),
            "profession_4" => __(ucfirst(str_replace('_', ' ', 'profession_4'))),
            "other_professions" => __(ucfirst(str_replace('_', ' ', 'other_professions'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    function searchFields()
    {
      return  [
            "company",
            "no_in_enrollment_length",
            "year_class",
            "no_for_roller_guidance_area",
            "letter_date",
            "education_level",
            "number_of_places_mentioned",
            "born_outside_varmland",
            "family",
        ];
    }


    function defaultTableColumns()
    {
        return [

            "place_of_birth",
            "date_of_birth",
            "residence_at_the_time_of_enrolment",
            "number_of_places_mentioned",
        ];
    }
}
