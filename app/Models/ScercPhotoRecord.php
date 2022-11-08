<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScercPhotoRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'old_id',
        'title',
        'description',
        'time_period',
        'type',
        'country',
        'state_province_county',
        'locality',
        'persons_on_photo',
        'photographer',
        'file_name',
        'secrecy',
        'archive_reference',
    ];


    public function SwedishChurchEmigrationRecord()
    {
        return $this->belongsTo(SwedishChurchEmigrationRecord::class);
    }
}
