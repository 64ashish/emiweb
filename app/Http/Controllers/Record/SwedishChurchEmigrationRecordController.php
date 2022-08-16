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

        $melieRaw = SwedishChurchEmigrationRecord::search($inputQuery,
            function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            run the filter
                $options['limit'] = 1000000;
                return $meilisearch->search($query, $options);
            })->raw();
        $idFromResults = collect($melieRaw['hits'])->pluck('id');
        $result = SwedishChurchEmigrationRecord::whereIn('id', $idFromResults)->whereRaw("DATE(STR_TO_DATE(`dob`, '%Y-%m-%d')) IS NOT NULL");



//        if search was being performed
        if($request->action === "search"){
//                return "search";
            $records = $result->paginate(100);
        }
//      filter the thing and get the results ready
        if($request->action === "filter"){
//                return $inputFields;
            $records = $this->FilterQuery($inputFields, $result, $all_request);
        }


        $keywords = $request->all();

        $model = new SwedishChurchEmigrationRecord();

        $filterAttributes = collect($model->defaultSearchFields());
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();

        $populated_fields = collect($inputFields)->except($defaultColumns)->keys();
        $archive_name = $model::findOrFail(1)->archive->name;


        return view('dashboard.swedishchurchemigrationrecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());
    }
}
