<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class JohnEricssonsArchiveRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'other_name',
        'description',
        'date',
        'roll_no',
        'file_name'
    ];


    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name' ))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name' ))),
            'other_name'=>__(ucfirst(str_replace('_', ' ', 'other_name' ))),
            'description'=>__(ucfirst(str_replace('_', ' ', 'Description' ))),
            'date'=>__(ucfirst(str_replace('_', ' ', 'date' ))),
            'roll_no'=>__(ucfirst(str_replace('_', ' ', 'roll_no' ))),
            'file_name'=>__(ucfirst(str_replace('_', ' ', 'file_name' ))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }


    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'other_name' => $this->other_name,
            'description' => $this->Description,
            'date' => $this->date,
            'roll_no' => $this->roll_no,
            'file_name' => $this->file_name
        ];
    }

    public function defaultSearchFields(){
        return [
            'first_name',
            'last_name',
            'other_name',
            'description',
            'date',
            'roll_no',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            'other_name',
            'description',
            'date',
            'roll_no',
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function enableQueryMatch(){
        return [
            'first_name',
            'last_name',
        ];
    }

    public function searchFields()
    {
        return [

        ];
    }
}
