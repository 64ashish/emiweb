<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwedishUsaCentersEmiPhotoRecord extends Model
{
    use HasFactory;

    protected $fillable = [
            'description',
            'location',
            'country',
            'photo_owner',
            'time_period',
            'film_number',
            'negative',
            'file_name'
         ];


    public function fieldsToDisply()
    {
        return [

            'description'=>__(ucfirst(str_replace('_', ' ', 'description' ))),
            'location'=>__(ucfirst(str_replace('_', ' ', 'location' ))),
            'country'=>__(ucfirst(str_replace('_', ' ', 'country' ))),
            'photo_owner'=>__(ucfirst(str_replace('_', ' ', 'photo_owner' ))),
            'time_period'=>__(ucfirst(str_replace('_', ' ', 'time_period' ))),
            'film_number'=>__(ucfirst(str_replace('_', ' ', 'film_number' ))),
            'negative'=>__(ucfirst(str_replace('_', ' ', 'negative' ))),
            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name' ))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function toSearchableArray()
    {
        return [
            'description',
            'location',
            'country',
        ];
    }

    public function defaultSearchFields(){
        return [
            'description',
            'time_period',
            'location',
            'country',
        ];
    }

    public function defaultTableColumns(){
        return [
            'description',
            'location',
            'country',
            'photo_owner',
            'time_period'
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
