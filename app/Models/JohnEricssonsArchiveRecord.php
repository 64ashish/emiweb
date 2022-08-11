<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class JohnEricssonsArchiveRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'other_name',
        'Description',
        'date',
        'roll_no',
        'file_name'
    ];

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
            'Description' => $this->Description,
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
            'Description',
            'date',
            'roll_no',
        ];
    }

    public function defaultTableColumns(){
        return [
            'other_name',
            'Description',
            'date',
            'roll_no',
        ];
    }
}
