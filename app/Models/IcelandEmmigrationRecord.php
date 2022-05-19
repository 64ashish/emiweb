<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcelandEmmigrationRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name','middle_name','last_name','original_name','date_of_birth','place_of_birth','destination_country','destination_location','home_location','departure','profession','travel_companion','return_info','travel_method','fathers_name','fathers_birth_location','mothers_name','mothers_birth_location','civil_status','partner_info','children','death_date','death_location','member_of_church','reference','genealogy','source','newspaper_info','photo','distction','member_of_organization','comment'   ];
}
