<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\NorwegianChurchImmigrantRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class NorwegianChurchImmigrantRecordController extends Controller
{
    //
    use SearchOrFilter;



    public function search( Request $request )
    {

        $all_request = $request->all();
        if(!empty($all_request['array_immigration_date']))
        {
            $all_request['array_to_date'] = $all_request['array_immigration_date'];
        }


//        return $all_request;
        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));


        if(Arr::has($inputFields, 'immigration_date'))
        {
            $inputFields['to_date'] =  $inputFields['immigration_date'];
            unset($inputFields['immigration_date']);
        }
        if(Arr::has($inputFields, 'immigration_county'))
        {
            $inputFields['to_fylke'] =  $inputFields['immigration_county'];
            unset($inputFields['immigration_county']);
        }
        if(Arr::has($inputFields, 'immigration_place'))
        {
            $inputFields['to_location'] =  $inputFields['immigration_place'];
            unset($inputFields['immigration_place']);
        }

        $model = new NorwegianChurchImmigrantRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result = NorwegianChurchImmigrantRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


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
//        return $archive_name;

//        return view
        return view('dashboard.NorwegianChurchImmigrantRecord.records', compact('records', 'keywords','enableQueryMatch', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted','provincesCoun'))->with($request->all());
    }
}
