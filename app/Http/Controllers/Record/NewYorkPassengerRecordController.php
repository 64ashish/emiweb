<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\NewYorkPassengerRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class NewYorkPassengerRecordController extends Controller
{
    use SearchOrFilter;
    //
    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

    public function search( Request $request )
    {


        $all_request = $request->all();
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action', 'page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));


        //        get the search result prepared
        if($request->action === "search"){
            $result = NewYorkPassengerRecord::search($inputQuery);
            $records = $result->paginate(100);
        }

//      filter the thing and get the results ready
        if($request->action === "filter"){

            $melieRaw = NewYorkPassengerRecord::search($inputQuery,
                function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            run the filter
                    $options['limit'] = 1000000;
                    return $meilisearch->search($query, $options);
                })->raw();
            $idFromResults = collect($melieRaw['hits'])->pluck('id');
            $result = NewYorkPassengerRecord::whereIn('id', $idFromResults);
//            filter is performed here
            $records = $this->FilterQuery($inputFields, $result, $all_request);

        }
//        get the filter attributes
//        $filterAttributes = $this->meilisearch->index('new_york_passenger_records')->getFilterableAttributes();
//        get the keywords again
        $keywords = $request->all();

        $model = new NewYorkPassengerRecord();
        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect($inputFields)->except($defaultColumns)->keys();
        $archive_name = $model::findOrFail(1)->archive->name;

//        return view
        return view('dashboard.NewYorkPassengerRecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());
    }
}
