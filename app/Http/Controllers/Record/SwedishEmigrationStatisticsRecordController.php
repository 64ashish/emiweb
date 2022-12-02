<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishEmigrationStatisticsRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class SwedishEmigrationStatisticsRecordController extends Controller
{
    use SearchOrFilter;




    public function search( Request $request )
    {


        $all_request = $request->all();

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));


        $model = new SwedishEmigrationStatisticsRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result = SwedishEmigrationStatisticsRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );

        $keywords = $request->all();




        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
//        $advancedFields = collect($model->defaultSearchFields())->flatten();
        $advancedFields = collect($model->advancedSearchFields());
//        return $advancedFields;
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();


//        return view
        return view('dashboard.scbe.records', compact('records', 'keywords', 'enableQueryMatch','filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());

    }


}
