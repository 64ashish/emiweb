<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Category extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [ 'name' ];

    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}
