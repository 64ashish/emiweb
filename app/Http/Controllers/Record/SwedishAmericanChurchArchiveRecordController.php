<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishAmericanChurchArchiveRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SwedishAmericanChurchArchiveRecordController extends Controller
{
        //
        use SearchOrFilter;


        public function search(Request $request)
        {

                //        dd($request->all());
                //        get the input data ready
                $all_request = $request->all();
                //        dd($request->qry_last_name['value']);
                if (!is_null(trim($all_request['qry_last_name']['value']))) {
                        $lastNames = explode(" ", trim($all_request['qry_last_name']['value']));
                        //            dd($lastNames[3]);
                        if (array_key_exists(1, $lastNames)) {
                                $all_request['last_name2'] = $lastNames[1];
                                $all_request['qry_last_name']['value'] = $lastNames[0];
                        }
                }

                //        dd($all_request);
                $quryables = $this->QryableItems($all_request);
                $carbonize_dates = $this->CarbonizeDates($all_request);
                $request->merge($carbonize_dates['field_data']);
                $remove_keys = Arr::prepend([Arr::flatten($carbonize_dates['date_keys']), $quryables], ['_token', 'action', 'page']);
                $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys), $quryables));

                //        return $inputQuery;
                $model = new SwedishAmericanChurchArchiveRecord();
                $fieldsToDisplay = $model->fieldsToDisplay();
                $enableQueryMatch = $model->enableQueryMatch();

                $result = SwedishAmericanChurchArchiveRecord::query();
                $this->QueryMatch($quryables, $result, $all_request);

                $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisplay));



                $keywords = $request->all();


                $filterAttributes = collect($model->defaultSearchFields());
                $advancedFields = collect($model->searchFields());
                $defaultColumns = $model->defaultTableColumns();
                $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns)->keys();
                //        return view
                $archive_name = $model::findOrFail(1)->archive;
                $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();
                $ProvincesParishes = collect($this->ProvincesParishes());
                //        $provinces = $this->provinces();



                  // Load view
                return view('dashboard.SwedishAmericanChurchArchiveRecord.records', 

                 // Send data to view
                compact('records', 'keywords', 'enableQueryMatch', 'filterAttributes', 
                'advancedFields', 'defaultColumns', 'populated_fields', 'archive_name', 
                'fieldsToDisplay', 'toBeHighlighted', 'ProvincesParishes'))->with($request->all());
        }

}
