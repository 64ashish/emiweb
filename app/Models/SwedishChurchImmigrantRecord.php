<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishChurchImmigrantRecord extends Model
{
    use HasFactory, Searchable, RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'last_name',
        'profession',
        'to_parish',
        'to_county',
        'to_date',
        'to_location',
        'from_location',
        'from_date',
        'from_country_code',
        'farm_name',
        'sex',
        'secrecy',
        'civil_status',
        'alone_or_family',
        'main_act',
        'act_nr',
        'birth_date',
        'birth_parish',
        'birth_county',
        'birth_location',
        'birth_country',
        'notes',
        'comment',
        'page_in_original',
        'nr_in_immigration_book',
        'before_from_parish',
        'before_from_date',
        'before_from_act_nr',
        'again_to_country',
        'again_to_date',
        'again_to_act_nr',
        'source',
        'orebro_act_nr',
        'source_hfl_batch_nr',
        'source_hfl_image_nr',
        'source_in_out_batch_nr',
        'source_in_out_image_nr'
    ];

    public function archive(){
        return $this->belongsTo(Archive::class);
    }

}
