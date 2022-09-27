<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwensonCenterPhotosamlingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
                    'title',
                    'description',
                    'photographer',
                    'studio',
                    'place',
                    'datum',
                    'collection_name',
                    'object_id',
                    'print_size',
                    'file_name'
                ];


    public function fieldsToDisply()
    {
        return [

            'title'=>__(ucfirst(str_replace('_', ' ', 'title'))),
            'description'=>__(ucfirst(str_replace('_', ' ', 'description'))),
            'photographer'=>__(ucfirst(str_replace('_', ' ', 'photographer'))),
            'studio'=>__(ucfirst(str_replace('_', ' ', 'studio'))),
            'place'=>__(ucfirst(str_replace('_', ' ', 'place'))),
            'datum'=>__(ucfirst(str_replace('_', ' ', 'datum'))),
            'collection_name'=>__(ucfirst(str_replace('_', ' ', 'collection_name'))),
            'object_id'=>__(ucfirst(str_replace('_', ' ', 'object_id'))),
            'print_size'=>__(ucfirst(str_replace('_', ' ', 'print_size'))),
            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name' ))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function toSearchableArray()
    {
        return [
            'title',
            'description',
            'photographer',
            'studio',
            'place',
        ];
    }

    public function defaultSearchFields(){
        return [
            'title',
            'photographer',
            'studio',
            'place',
            'collection_name'
//            'film_number',
        ];
    }

    public function defaultTableColumns(){
        return [
            'title',
//            'description',
            'photographer',
            'studio',
            'place',
            'collection_name'
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
