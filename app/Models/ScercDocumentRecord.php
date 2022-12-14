<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScercDocumentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'old_id',
        'description',
        'type',
        'file_name',
        'archive_reference',
        'secrecy',
        'time_period',
    ];

    public function SwedishChurchEmigrationRecord()
    {
        return $this->belongsTo(SwedishChurchEmigrationRecord::class);
    }

    public function searchFields()
    {
        return [
            'type',
            'description',
            'time_period',
            'archive_reference'
        ];
    }
}
