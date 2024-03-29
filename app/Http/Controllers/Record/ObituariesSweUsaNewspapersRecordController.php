<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\ObituariesSweUsaNewspapersRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ObituariesSweUsaNewspapersRecordController extends Controller
{
    //
    use SearchOrFilter;


    public function search(Request $request)
    {

        $all_request = $request->all();

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));

        $model = new ObituariesSweUsaNewspapersRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result =  ObituariesSweUsaNewspapersRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);

        $result = $result;

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );
//        return $result;

        $keywords = $request->all();

        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(501)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();
        $provinces1 = $this->ProvincesParishes();
        $provincesCoun = array();
        foreach($provinces1 as $key => $value){
            $provincesCoun[$value['code']] = $value['county'];
        }
        foreach($records as $k => $data){
            foreach($provincesCoun as $sort => $county){
                if($data->from_province == $sort){
                    $data->from_province = $county;
                }
            }
            foreach($provincesCoun as $sort => $county){
                if($data->county_in_sweden == $sort){
                    $data->county_in_sweden = $county;
                }
            }
        }

        return view('dashboard.Ofsan.records', compact('records', 'enableQueryMatch','keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted','provincesCoun'))->with($request->all());


    }
}
