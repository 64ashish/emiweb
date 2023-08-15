<?php

namespace App\Models;

use App\Traits\RecordCount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class SwedishChurchImmigrantRecord extends Model
{
    use HasFactory,  RecordCount;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * Get the fields to display in the model.
     *
     * @return array
     */
    public function fieldsToDisply()
    {
        return [
            'first_name' => __(ucfirst(str_replace('_', ' ', 'first_name'))),
            'last_name' => __(ucfirst(str_replace('_', ' ', 'last_name'))),
            'profession' => __(ucfirst(str_replace('_', ' ', 'profession'))),
            'to_parish' => __(ucfirst(str_replace('_', ' ', 'to_parish'))),
            'to_county' => __(ucfirst(str_replace('_', ' ', 'to_county'))),
            'to_date' => __(ucfirst(str_replace('_', ' ', 'to_date'))),
            'to_location' => __(ucfirst(str_replace('_', ' ', 'to_location'))),
            'from_location' => __(ucfirst(str_replace('_', ' ', 'from_location'))),
            'from_date' => __(ucfirst(str_replace('_', ' ', 'from_date'))),
            'from_country_code' => __(ucfirst(str_replace('_', ' ', 'from_country_code'))),
            'farm_name' => __(ucfirst(str_replace('_', ' ', 'farm_name'))),
            'sex' => __(ucfirst(str_replace('_', ' ', 'sex'))),
            'secrecy' => __(ucfirst(str_replace('_', ' ', 'secrecy'))),
            'civil_status' => __(ucfirst(str_replace('_', ' ', 'civil_status'))),
            'alone_or_family' => __(ucfirst(str_replace('_', ' ', 'alone_or_family'))),
            'main_act' => __(ucfirst(str_replace('_', ' ', 'main_act'))),
            'act_nr' => __(ucfirst(str_replace('_', ' ', 'act_nr'))),
            'birth_date' => __(ucfirst(str_replace('_', ' ', 'birth_date'))),
            'birth_parish' => __(ucfirst(str_replace('_', ' ', 'birth_parish'))),
            'birth_county' => __(ucfirst(str_replace('_', ' ', 'birth_county'))),
            'birth_location' => __(ucfirst(str_replace('_', ' ', 'birth_location'))),
            'birth_country' => __(ucfirst(str_replace('_', ' ', 'birth_country'))),
            'notes' => __(ucfirst(str_replace('_', ' ', 'notes'))),
            'comment' => __(ucfirst(str_replace('_', ' ', 'comment'))),
            'page_in_original' => __(ucfirst(str_replace('_', ' ', 'page_in_original'))),
            'nr_in_immigration_book' => __(ucfirst(str_replace('_', ' ', 'nr_in_immigration_book'))),
            'before_from_parish' => __(ucfirst(str_replace('_', ' ', 'before_from_parish'))),
            'before_from_date' => __(ucfirst(str_replace('_', ' ', 'before_from_date'))),
            'before_from_act_nr' => __(ucfirst(str_replace('_', ' ', 'before_from_act_nr'))),
            'again_to_country' => __(ucfirst(str_replace('_', ' ', 'again_to_country'))),
            'again_to_date' => __(ucfirst(str_replace('_', ' ', 'again_to_date'))),
            'again_to_act_nr' => __(ucfirst(str_replace('_', ' ', 'again_to_act_nr'))),
            'source' => __(ucfirst(str_replace('_', ' ', 'source'))),
            'orebro_act_nr' => __(ucfirst(str_replace('_', ' ', 'orebro_act_nr'))),
            'source_hfl_batch_nr' => __(ucfirst(str_replace('_', ' ', 'source_hfl_batch_nr'))),
            'source_hfl_image_nr' => __(ucfirst(str_replace('_', ' ', 'source_hfl_image_nr'))),
            'source_in_out_batch_nr' => __(ucfirst(str_replace('_', ' ', 'source_in_out_batch_nr'))),
            'source_in_out_image_nr' => __(ucfirst(str_replace('_', ' ', 'source_in_out_image_nr'))),
            'id' => 'id',
            'archive_id' => __(ucfirst(str_replace('_', ' ', "archive_id")))
        ];
    }

    /**
     * Get the archive associated with the SwedishChurchImmigrantRecord.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function archive()
    {
        return $this->belongsTo(Archive::class);
    }

    /**
     * Convert the model instance to an array for searchable indexing.
     *
     * @return array
     */
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

    /**
     * Get the default search fields for the model.
     *
     * @return array
     */
    public function defaultSearchFields()
    {
        return [
            'first_name',
            'last_name',
            'birth_date',
            ['birth_county', 'birth_parish'],
            '---',
            'to_date',
            'to_location',
            ['to_county', 'to_parish'],
            'birth_country',
            'from_country_code',
            'from_date',
            'from_location',

        ];
    }

    /**
     * Get the default table columns for the model.
     *
     * @return array
     */
    public function defaultTableColumns()
    {
        return [
            //            'first_name',
            //            'last_name',
            'birth_date',
            'from_location',
            'to_date',


            //'profession',
            'to_location',
            'to_county',

            //'sex',
            //'civil_status',
            'birth_country',
        ];
    }
    /**
     * Get the formatted birth date attribute.
     *
     * @param  string  $value
     * @return string
     */
    public function getBirthDateAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Get the user associated with the SwedishChurchImmigrantRecord.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to filter records by gender.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $gender
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindGender($query, $gender)
    {
        if ($gender === "Män") {
            return $query->where('sex', 'M');
        }
        if ($gender === "Kvinnor") {
            return $query->where('sex', 'K');
        }
        return $query;
    }

    /**
     * Scope a query to filter records by date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null  $start_year
     * @param  string|null  $end_year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecordDateRange($query, $start_year, $end_year)
    {

        //        if only start date is given

        if ($start_year != null and $end_year == null) {
            return $query->whereNotNull(DB::raw('YEAR(to_date)'))
                ->where(DB::raw('YEAR(to_date)'), $start_year);
        }
        if (($start_year != null and $end_year != null) and ($start_year < $end_year)) {
            return  $query->whereNotNull(DB::raw('YEAR(to_date)'))
                ->whereBetween(DB::raw('YEAR(to_date)'), [$start_year, $end_year]);
        }
        //        dd($query->get());
        return $query;
    }

    /**
     * Get the fields to enable query matching.
     *
     * @return array
     */
    public function scopeFindProvince($query, $province)
    {
        if ($province !== "0") {
            return $query->where('birth_county', $province);
        }
        return $query;
    }

    /**
     * Scope a query to filter records by province.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $province
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindParish($query, $parish)
    {
        if ($parish !== "0") {
            return $query->where('birth_parish', $parish);
        }
        return $query;
    }

    /**
     * Scope a query to filter records by parish.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $parish
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGroupRecordsBy($query, $group_by)
    {
        if ($group_by === "to_date") {
            return $query->select(DB::raw('YEAR(to_date) as year'), DB::raw('COUNT(*) as total'))
                ->groupByRaw('YEAR(to_date)')
                ->orderByDesc('year');
        }

        if ($group_by === "to_county") {
            return $query->whereNot('to_county', '0')
                ->select('to_county', DB::raw("COUNT(*) as total"))
                ->groupByRaw('to_county');
        }

        return $query;
    }

    /**
     * Get the fields to enable query matching.
     *
     * @return array
     */
    public function enableQueryMatch()
    {
        return [
            'first_name',
            'last_name',
            'birth_parish',
            'to_location',
            'to_parish',
            'from_country_code',
            'birth_location'
        ];
    }

    /**
     * Get the search fields for the model.
     *
     * @return array
     */
    public function searchFields()
    {
        return [
            'profession',
            'sex',
            'civil_status',
            'alone_or_family',
            'birth_location',
            'farm_name',
            '---',
            'main_act',
            'act_nr',
            'nr_in_immigration_book',
            '---',
            'comment',
            'notes',
            '---',
            'before_from_date',
            'before_from_parish',
            'before_from_act_nr',
            'again_to_date',
            'again_to_country',
            'again_to_act_nr',
            '---',
            'source',
            'page_in_original',
            'source_hfl_batch_nr',
            'source_hfl_image_nr',
            'source_in_out_batch_nr',
            'source_in_out_image_nr',
            'secrecy',
        ];
    }
}
