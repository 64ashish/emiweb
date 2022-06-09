<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ImageCollection extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'details',
        'type',
        'url',
    ];

    public function archives()
    {
        $this->belongsToMany(Archive::class, 'archive_image_collection');
    }
}
