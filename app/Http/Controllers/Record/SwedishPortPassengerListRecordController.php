<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishPortPassengerListRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class  SwedishPortPassengerListRecordController extends Controller
{
    //
    use SearchOrFilter;



    public function search( Request $request )
    {

        $all_request = $request->all();
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));



        $model = new SwedishPortPassengerListRecord();
        $fieldsToDisply = $model->fieldsToDisply();


        $result = SwedishPortPassengerListRecord::query();
        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );

        //        get the search result prepared
//        if($request->action === "search"){
//            $result = SwedishPortPassengerListRecord::search($inputQuery);
//            $records = $result->paginate(100);
//        }
//
////      filter the thing and get the results ready
//        if($request->action === "filter"){
//            $melieRaw = SwedishPortPassengerListRecord::search($inputQuery,
//                function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
////            run the filter
//                    $options['limit'] = 1000000;
//                    return $meilisearch->search($query, $options);
//                })->raw();
//            $idFromResults = collect($melieRaw['hits'])->pluck('id');
//            $result = SwedishPortPassengerListRecord::whereIn('id', $idFromResults);
////            filter is performed here
//            $records = $this->FilterQuery($inputFields, $result, $all_request);
//        }

//        get the filter attributes
//        $filterAttributes = $this->meilisearch->index('swedish_port_passenger_list_records')->getFilterableAttributes();
//        get the keywords again
        $keywords = $request->all();




        $filterAttributes = collect($model->defaultSearchFields());


        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();


//        return view
        return view('dashboard.SwedishPortPassengerListRecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());
    }
}
