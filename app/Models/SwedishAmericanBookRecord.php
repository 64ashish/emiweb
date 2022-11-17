<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwedishAmericanBookRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'birth_place',
        'residence_city',
        'county',
        'state',
        'page_reference',
    ];


    public function fieldsToDisply()
    {
        return [
            'first_name'=> __(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=> __(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_date'=> __(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'birth_place'=> __(ucfirst(str_replace('_', ' ', 'birth_place'))),
            'residence_city'=> __(ucfirst(str_replace('_', ' ', 'residence_city'))),
            'county'=> __(ucfirst(str_replace('_', ' ', 'county'))),
            'state'=> __(ucfirst(str_replace('_', ' ', 'state'))),
            'page_reference'=> __(ucfirst(str_replace('_', ' ', 'page_reference'))),
//            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function toSearchableArray()
    {
        return [
            'first_name',
            'last_name',
            'birth_date',
            'birth_place',
            'residence_city',
            'county',
            'state',
            'page_reference',
        ];
    }

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'birth_date',
            'birth_place',
//            'residence_city',
//            'county',
//            'state',
//            'page_reference',
        ];
    }

    public function defaultTableColumns(){
        return [
            'first_name',
            'last_name',
            'birth_date',
            'birth_place',
            'residence_city',
//            'county',
//            'state',
//            'page_reference',
        ];
    }

    public function SwensonBookData()
    {
        return $this->belongsTo(SwensonBookData::class, 'book_id');
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
        ];
    }
}
