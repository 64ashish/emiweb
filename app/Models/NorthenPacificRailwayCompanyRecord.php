<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorthenPacificRailwayCompanyRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [];


    public function toSearchableArray()
    {
        return [

        ];
    }

    public function defaultSearchFields(){
        return [

        ];
    }

    public function defaultTableColumns(){
        return [

        ];
    }

    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function enableQueryMatch(){
        return [
        ];
    }
}
