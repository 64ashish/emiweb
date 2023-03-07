<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\NorwayEmigrationRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class NorwayEmigrationRecordController extends Controller
{
    use SearchOrFilter;

    //


    public function search( Request $request )
    {
        $all_request = $request->all();

        if(!empty($all_request['array_emigration_date']))
        {
            $all_request['array_registered_date'] = $all_request['array_emigration_date'];
        }

//
//        unset($all_request['array_emigration_date']);

//        return $all_request;

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));


        if(Arr::has($inputFields, 'emigration_date'))
            {
                $inputFields['registered_date'] =  $inputFields['emigration_date'];
                unset($inputFields['emigration_date']);
            }
        if(Arr::has($inputFields, 'emigration_county'))
            {
                $inputFields['from_region'] =  $inputFields['emigration_county'];
                unset($inputFields['emigration_county']);
            }
        if(Arr::has($inputFields, 'emigration_place'))
            {
                $inputFields['from_location'] =  $inputFields['emigration_place'];
                unset($inputFields['emigration_place']);
            }

//        return $inputFields;

        $model = new NorwayEmigrationRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();

        $result = NorwayEmigrationRecord::query();
//        return $inputFields;
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );

        $keywords = $request->all();


        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();


//        return view
        return view('dashboard.norwayemigrationrecord.records', compact('records', 'keywords','enableQueryMatch', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());
    }



}
