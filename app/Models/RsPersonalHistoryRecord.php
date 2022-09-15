<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsPersonalHistoryRecord extends Model
{
    use HasFactory, RecordCount;

    protected $fillable = [

        'name',
        'source',
        'profession',
        'country',
        'filename'
    ];

    public function toSearchableArray()
    {
        return [
            'name',
            'source',

            'profession',
            'country',
            'filename'
        ];
    }

    public function defaultSearchFields(){
        return [

            'name',
            'source',
            'profession',
            'country',
            'filename'
        ];
    }

    public function defaultTableColumns(){
        return [
            'name',
            'source',
            'profession',
            'country',
            'filename'
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
}
