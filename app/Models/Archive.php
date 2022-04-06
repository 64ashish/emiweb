<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'detail','place'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'archive_organization');
    }
}
