<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\ScercPhotoRecord;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Traits\SearchOrFilter;
use Psr\Log\NullLogger;

class SwedishChurchEmigrationRecordController extends Controller
{
    use SearchOrFilter;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function search( Request $request )
    {
//        return $request->all();
        $all_request = $request->all();
//        return $all_request['qry_first_name']['value'] ;
        $quryables = $this->QryableItems($all_request);
//        return $quryables;

        $carbonize_dates = $this->CarbonizeDates($all_request);
//        return $carbonize_dates;
//        return Arr::flatten($all_request['first_name']);
        $request->merge($carbonize_dates['field_data']);
//        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );

//      return $remove_keys;
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));

//      return $inputFields;





//        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));
//        return $inputQuery;
        $model = new SwedishChurchEmigrationRecord();

        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();
//
//        return in_array('ashish', $enableQueryMatch);

        $result = SwedishChurchEmigrationRecord::query();


        $this->QueryMatch($quryables,$result, $all_request);


        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );





        $keywords = $request->all();



        $filterAttributes = collect($model->defaultSearchFields());
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();


        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
//        return $defaultColumns;
        $archive_name = $model::findOrFail(1)->archive;




        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();

//        return $keywords;

        return view('dashboard.swedishchurchemigrationrecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name', 'fieldsToDisply','toBeHighlighted','enableQueryMatch'))->with($request->all());

    }

    public function statics(){


        $provinces = SwedishChurchEmigrationRecord::whereNot('from_province', '0')
            ->select('from_province')
            ->distinct()
            ->get()
            ->pluck('from_province','from_province')->prepend('Alla');

//        return $provinces;
        return view('dashboard.swedishchurchemigrationrecord.statistics', compact('provinces'));

    }

    public function generateChart( Request $request)
    {


        $data = SwedishChurchEmigrationRecord::findGender($request->gender)
                ->fromProvince($request->from_province)
                ->recordDateRange($request->start_year,$request->end_year)
                ->groupRecordsBy($request->group_by)
                ->get();


        $provinces = SwedishChurchEmigrationRecord::whereNot('from_province', '0')
            ->select('from_province')
            ->distinct()
            ->get()
            ->pluck('from_province','from_province')->prepend('Alla');

        $title = 'Emigration ' .
                (($request->gender !== "Alla") ? "av $request->gender ": "") .
                (($request->from_province !== "0") ? "från $request->from_province ": "") .
                (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
            (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;

//        return $data;
        $grouped_by = $request->group_by === "record_date"? "year":"from_province";
        $chart_type = $request->chart_type;
        $keywords = $request->all();
        return view('dashboard.swedishchurchemigrationrecord.statistics', compact('provinces','data', 'chart_type','title', 'grouped_by','keywords'));
    }


    public function searchPhotos()
    {
        return view('dashboard.swedishchurchemigrationrecord.photos');
    }

    public function resultPhotos(Request $request)
    {
        $keywords = array_filter( $request->except('_token'));

        $query = ScercPhotoRecord::query();

        foreach($keywords as $fieldName => $value)
        {

            if(  $fieldName === 'title' or $fieldName==='description')
            {
                $query->whereFullText($fieldName, $value);
            }
            if( $fieldName !== 'title' and $fieldName !=='description')
            {
                $query->where($fieldName, $value);
            }
        }

        $records = $query->paginate(100);

//        return $records->total();
        return view('dashboard.swedishchurchemigrationrecord.photos',
            compact('records'));
    }
}
