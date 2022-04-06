<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name' ,
        'phone' ,
        'email',
        'location',
        'address',
        'city',
        'postcode',
        'province' ,
        'fax' ,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Users()
    {
        return $this->hasMany(User::class);
    }

    public function archives()
    {
        return $this->belongsToMany(Archive::class, 'archive_organization');
    }

}
