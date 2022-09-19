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
