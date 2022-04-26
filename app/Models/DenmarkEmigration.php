<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class DenmarkEmigration extends Model
{
    use HasFactory, Searchable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'birth_place' => $this->birth_place,
            'last_resident' => $this->last_resident,
            'profession' => $this->profession,
            'destination_city' => $this->destination_city,
            'destination_country' => $this->destination_country,
            'ship_name' => $this->ship_name,
            ];
    }
}
