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

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));



        $model = new SwedishPortPassengerListRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result = SwedishPortPassengerListRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );

//        return $records;





        $keywords = $request->all();




        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();

        $provinces1 = $this->ProvincesParishes();
        $provincesCoun = array();
        foreach($provinces1 as $key => $value){
            $provincesCoun[$value['code']] = $value['county'];
        }
        foreach($records as $k => $data){
            foreach($provincesCoun as $sort => $county){
                if($data->departure_county == $sort){
                    $data->departure_county = $county;
                }
            }
        }
        if (array_key_exists('departure_port_text', $keywords) && Arr::exists($keywords,"compare_departure_port_check")) {
        }else{
            if (array_key_exists('departure_port_text', $keywords)){
                unset($keywords['departure_port_text']);
            }
        }
        // pre($records); exit;
        return view('dashboard.SwedishPortPassengerListRecord.records', compact('records', 'enableQueryMatch','keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted','provincesCoun'))->with($request->all());
    }
}
