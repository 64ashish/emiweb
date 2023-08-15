<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function enableQueryMatch(){
        return [
        ];
    }

    public function searchFields()
    {
        return [
            'old_id',
            'title',
            'description',
            'time_period',
            'country',
            'state_province_county',
            'locality',
            'persons_on_photo',
            'photographer',
            'archive_reference'
        ];
    }

    protected function fileName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Storage::disk('s3')->temporaryUrl('archives/5/photos'.Str::replace(' ', '+', $value), now()->addMinutes(60))
        );
    }
}
