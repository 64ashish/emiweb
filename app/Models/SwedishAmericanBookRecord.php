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
}
