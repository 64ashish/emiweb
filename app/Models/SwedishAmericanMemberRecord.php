<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishAmericanMemberRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'page',
        'first_name',
        'last_name',
        'birth_date',
        'birth_parish',
        'birth_county',
        'lodge',
        'lodge_nr',
        'order_type',
        'place',
        'state',
        'film_nr',
        'source',
        'user_id'
    ];


    public function fieldsToDisply()
    {
        return [


            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'birth_parish'=>__(ucfirst(str_replace('_', ' ', 'birth_parish'))),
            'birth_county'=>__(ucfirst(str_replace('_', ' ', 'birth_county'))),
            'lodge'=>__(ucfirst(str_replace('_', ' ', 'lodge'))),
            'page'=>__(ucfirst(str_replace('_', ' ', 'page'))),
            'lodge_nr'=>__(ucfirst(str_replace('_', ' ', 'lodge_nr'))),
            'order_type'=>__(ucfirst(str_replace('_', ' ', 'order_type'))),
            'place'=>__(ucfirst(str_replace('_', ' ', 'place'))),
            'state'=>__(ucfirst(str_replace('_', ' ', 'state'))),
            'film_nr'=>__(ucfirst(str_replace('_', ' ', 'film_nr'))),
            'source'=>__(ucfirst(str_replace('_', ' ', 'source'))),
//            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name' ))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    public function defaultSearchFields()
    {
        return [
//            'first_name',
//            'last_name',
            'birth_date',
            'birth_parish',
            'birth_county',
            'place',
            'state',
        ];
    }

    public function defaultTableColumns(){
        return [
            'birth_date',
            'birth_parish',
            'birth_county',
            'place',
            'state',
            'lodge',
        ];
    }

    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
