<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Archive;

class DalslanningarBornInAmericaRecord extends Model
{

    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'last_name',
        'first_name',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'profession',
        'source_nr',
        'comments',
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultTableColumns(){
        return [

            'first_name',
            'last_name',
            'birth_date',
            'birth_place',
            'profession',
        ];
    }


    public function fieldsToDisply()
    {
        return [
            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'birth_place'=>__(ucfirst(str_replace('_', ' ', 'birth_place'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }


    public function defaultSearchFields(){
        return [

//            'first_name',
//            'last_name',
            'birth_date',
            'birth_place',
            'profession',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function enableQueryMatch(){
        return [
        ];
    }
}
