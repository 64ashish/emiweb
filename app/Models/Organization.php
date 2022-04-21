<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Organization extends Model
{
    use HasFactory, HasRoles;

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
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function archives()
    {
        return $this->belongsToMany(Archive::class, 'archive_organization');
    }

    public function association()
    {
        return $this->hasMany(Association::class);
    }



}
