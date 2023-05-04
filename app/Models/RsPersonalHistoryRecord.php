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

    public function fieldsToDisply()
    {
        return [
            'name'=> __(ucfirst(str_replace('_', ' ', 'name'))),
            'source'=> __(ucfirst(str_replace('_', ' ', 'source'))),
            'profession'=> __(ucfirst(str_replace('_', ' ', 'profession'))),
            'country'=> __(ucfirst(str_replace('_', ' ', 'country'))),
            'filename'=> __(ucfirst(str_replace('_', ' ', 'filename'))),
//            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

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
            'country'
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

    public function enableQueryMatch(){
        return [
            'name',
        ];
    }

    public function searchFields()
    {
        return [

        ];
    }
}
