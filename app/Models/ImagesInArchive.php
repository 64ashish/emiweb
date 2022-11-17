<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagesInArchive extends Model
{
    use HasFactory;

    protected $fillable = [
        'context',
        'record_id',
        'collection_id',
        'image_name'
    ];

    public function enableQueryMatch(){
        return [
        ];
    }
}
