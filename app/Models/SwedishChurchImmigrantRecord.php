<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
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

    public function fieldsToDisply()
    {
        return [
            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'to_parish'=>__(ucfirst(str_replace('_', ' ', 'to_parish'))),
            'to_county'=>__(ucfirst(str_replace('_', ' ', 'to_county'))),
            'to_date'=>__(ucfirst(str_replace('_', ' ', 'to_date'))),
            'to_location'=>__(ucfirst(str_replace('_', ' ', 'to_location'))),
            'from_location'=>__(ucfirst(str_replace('_', ' ', 'from_location'))),
            'from_date'=>__(ucfirst(str_replace('_', ' ', 'from_date'))),
            'from_country_code'=>__(ucfirst(str_replace('_', ' ', 'from_country_code'))),
            'farm_name'=>__(ucfirst(str_replace('_', ' ', 'farm_name'))),
            'sex'=>__(ucfirst(str_replace('_', ' ', 'sex'))),
            'secrecy'=>__(ucfirst(str_replace('_', ' ', 'secrecy'))),
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'alone_or_family'=>__(ucfirst(str_replace('_', ' ', 'alone_or_family'))),
            'main_act'=>__(ucfirst(str_replace('_', ' ', 'main_act'))),
            'act_nr'=>__(ucfirst(str_replace('_', ' ', 'act_nr'))),
            'birth_date'=>__(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'birth_parish'=>__(ucfirst(str_replace('_', ' ', 'birth_parish'))),
            'birth_county'=>__(ucfirst(str_replace('_', ' ', 'birth_county'))),
            'birth_location'=>__(ucfirst(str_replace('_', ' ', 'birth_location'))),
            'birth_country'=>__(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'notes'=>__(ucfirst(str_replace('_', ' ', 'notes'))),
            'comment'=>__(ucfirst(str_replace('_', ' ', 'comment'))),
            'page_in_original'=>__(ucfirst(str_replace('_', ' ', 'page_in_original'))),
            'nr_in_immigration_book'=>__(ucfirst(str_replace('_', ' ', 'nr_in_immigration_book'))),
            'before_from_parish'=>__(ucfirst(str_replace('_', ' ', 'before_from_parish'))),
            'before_from_date'=>__(ucfirst(str_replace('_', ' ', 'before_from_date'))),
            'before_from_act_nr'=>__(ucfirst(str_replace('_', ' ', 'before_from_act_nr'))),
            'again_to_country'=>__(ucfirst(str_replace('_', ' ', 'again_to_country'))),
            'again_to_date'=>__(ucfirst(str_replace('_', ' ', 'again_to_date'))),
            'again_to_act_nr'=>__(ucfirst(str_replace('_', ' ', 'again_to_act_nr'))),
            'source'=>__(ucfirst(str_replace('_', ' ', 'source'))),
            'orebro_act_nr'=>__(ucfirst(str_replace('_', ' ', 'orebro_act_nr'))),
            'source_hfl_batch_nr'=>__(ucfirst(str_replace('_', ' ', 'source_hfl_batch_nr'))),
            'source_hfl_image_nr'=>__(ucfirst(str_replace('_', ' ', 'source_hfl_image_nr'))),
            'source_in_out_batch_nr'=>__(ucfirst(str_replace('_', ' ', 'source_in_out_batch_nr'))),
            'source_in_out_image_nr'=>__(ucfirst(str_replace('_', ' ', 'source_in_out_image_nr'))),
            'id'=>'id',
            'archive_id'=>'archive_id'
        ];
    }

    public function archive(){
        return $this->belongsTo(Archive::class);
    }

    public function toSearchableArray()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'profession' => $this->profession,
            'to_parish' => $this->to_parish,
            'to_county' => $this->to_county,
            'to_location' => $this->to_location,
            'from_location' => $this->from_location,
            'farm_name' => $this->farm_name,
            'sex' => $this->sex,
            'civil_status' => $this->civil_status,
            'birth_parish' => $this->birth_parish,
            'birth_county' => $this->birth_county,
            'birth_location' => $this->birth_location,
            'birth_country' => $this->birth_country,
            'notes' => $this->notes,
            'comment' => $this->comment,
            'birth_date' => $this->birth_date,
            'from_date' => $this->from_date,
            'to_date' => $this->to_date
            ];
    }

    public function defaultSearchFields()
    {
        return [
//        'first_name',
//        'last_name',
        'profession',
        'to_parish',
        'to_county',
        'to_date',
        'to_location',
        'from_location',
        'from_date',
        'sex',
        'birth_date',
        'birth_parish',
        'birth_county',
        'birth_location',
        'birth_country'
            ];
    }

    public function defaultTableColumns(){
        return [
            'profession',
            'to_location',
            'from_location',
            'sex',
            'civil_status',
            'birth_country',
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
