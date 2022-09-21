<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;
use App\Traits\SearchOrFilter;
use Psr\Log\NullLogger;

class SwedishChurchEmigrationRecordController extends Controller
{
    use SearchOrFilter;

    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function search( Request $request )
    {


        $all_request = $request->all();
//        return $all_request;
        $carbonize_dates = $this->CarbonizeDates($all_request);
//        return $carbonize_dates;
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action','page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
//        return $inputFields;
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));

//        return $inputQuery;


        $result = SwedishChurchEmigrationRecord::query();

//        return $inputFields;
        $records = $this->FilterQuery($inputFields, $result, $all_request);

////        if search was being performed
//        if($request->action === "search"){
//          $result = SwedishChurchEmigrationRecord::query();
//            $records = $this->FilterQuery($inputFields, $result, $all_request);
//        }
////      filter the thing and get the results ready
//        if($request->action === "filter"){
//            $melieRaw = SwedishChurchEmigrationRecord::search($inputQuery,
//                function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
////            run the filter
//                    $options['limit'] = 1000000;
//                    return $meilisearch->search($query, $options);
//                })->raw();
//            $idFromResults = collect($melieRaw['hits'])->pluck('id');
//            $result = SwedishChurchEmigrationRecord::whereIn('id', $idFromResults)->whereRaw("DATE(STR_TO_DATE(`dob`, '%Y-%m-%d')) IS NOT NULL");
//            $records = $this->FilterQuery($inputFields, $result, $all_request);
//        }


//        return $records;

        $keywords = $request->all();

        $model = new SwedishChurchEmigrationRecord();

        $filterAttributes = collect($model->defaultSearchFields());
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();

        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
//        return $defaultColumns;
        $archive_name = $model::findOrFail(1)->archive;

//        return $records;

        return view('dashboard.swedishchurchemigrationrecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());
    }
}
