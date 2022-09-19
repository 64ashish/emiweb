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
            'location',
            'country',
            'photo_owner',
            'time_period',
//            'film_number',
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
}
