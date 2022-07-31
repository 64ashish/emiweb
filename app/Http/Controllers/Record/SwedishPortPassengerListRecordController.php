<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishPortPassengerListRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class SwedishPortPassengerListRecordController extends Controller
{
    //
    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

    public function search( Request $request )
    {

//        get the input data ready
        $inputFields = Arr::whereNotNull($request->except('_token', 'first_name', 'last_name','action' ));
//        prepare for filter
        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
//        prepare for search
        if($request->action === "search")
        {
            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
        }

        $result = SwedishPortPassengerListRecord::search($inputQuery);

        //        get the search result prepared
        if($request->action === "search"){
            $records = $result->paginate(100);
        }

//      filter the thing and get the results ready
        if($request->action === "filter"){


            $filtered = $result->get();

            foreach($inputFields as  $fieldname => $fieldvalue){
                $filtered =  $filtered->whereIn($fieldname, $fieldvalue);
            }
            $records = $filtered->paginate(100);

        }

//        get the filter attributes
        $filterAttributes = $this->meilisearch->index('swedish_port_passenger_list_records')->getFilterableAttributes();
//        get the keywords again
        $keywords = $request->all();


        $model = new SwedishPortPassengerListRecord();


        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(array_filter($request->except(['first_name','last_name','action','_token','query', 'page']), 'strlen'))->except($defaultColumns)->keys();
//        return view
        return view('dashboard.SwedishPortPassengerListRecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields'))->with($request->all());
    }
}
