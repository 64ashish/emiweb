<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class SwedishImmigrationStatisticsRecord extends Model
{
    use HasFactory,  RecordCount;

    protected $fillable = [
        'user_id',
        'archive_id',
        'old_id',
        'first_name',
        'profession',
        'last_name',
        'birth_year',
        'birth_month',
        'birth_day',
        'from_country',
        'comments',
        'family_nr',
        'nationality',
        'source',
        'sex',
        'civil_status',
        'svar_batch_nr',
        'svar_image_nr',
        'to_year',
        'to_province',
        'to_parish'
    ];

    public function fieldsToDisply()
    {
        return [

            'first_name'=>__(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name'=>__(ucfirst(str_replace('_', ' ', 'last_name'))),
            'profession'=>__(ucfirst(str_replace('_', ' ', 'profession'))),
            'birth_year'=>__(ucfirst(str_replace('_', ' ', 'birth_year'))),
            'birth_month'=>__(ucfirst(str_replace('_', ' ', 'birth_month'))),
            'birth_day'=>__(ucfirst(str_replace('_', ' ', 'birth_day'))),
            'from_country'=>__(ucfirst(str_replace('_', ' ', 'from_country'))),
            'comments'=>__(ucfirst(str_replace('_', ' ', 'comments'))),
            'family_nr'=>__(ucfirst(str_replace('_', ' ', 'family_nr'))),
            'nationality'=>__(ucfirst(str_replace('_', ' ', 'nationality'))),
            'source'=>__(ucfirst(str_replace('_', ' ', 'source'))),
            'sex'=>__(ucfirst(str_replace('_', ' ', 'sex'))),
            'civil_status'=>__(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'svar_batch_nr'=>__(ucfirst(str_replace('_', ' ', 'svar_batch_nr'))),
            'svar_image_nr'=>__(ucfirst(str_replace('_', ' ', 'svar_image_nr'))),
            'to_year'=>__(ucfirst(str_replace('_', ' ', 'to_year'))),
            'to_province'=>__(ucfirst(str_replace('_', ' ', 'to_province'))),
            'to_parish'=>__(ucfirst(str_replace('_', ' ', 'to_parish'))),
            'id'=>'id',
            'archive_id'=>__(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
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
            'profession' => $this->profession,
            'last_name' => $this->last_name,
            'from_country' => $this->from_country,
            'comments' => $this->comments,
            'nationality' => $this->nationality,
            'source' => $this->source,
            'civil_status' => $this->civil_status,
            'to_province' => $this->to_province,
            'to_parish' => $this->to_parish,
            'birth_year' => $this->birth_year,
            'sex' => $this->sex,
            'to_year' => $this->to_year,
        ];
    }

    public function defaultSearchFields()
    {
        return [
            'first_name',
            'last_name',
            ['birth_year',
            'birth_month',
            'birth_day'],
            'profession',
            '---',
            'to_year',
            ['to_province',
                'to_parish'],
            'from_country',
            'id',
        ];
    }

    public function defaultTableColumns(){
        return [
//            'first_name',
//            'last_name',
            // 'profession',
            'birth_year',
            // 'nationality',
            // 'civil_status',
            'to_year',
            'to_province', 
            'to_parish',
            'from_country',];
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
