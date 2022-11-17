<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishAmericanJubileeRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SwedishAmericanJubileeRecordController extends Controller
{
    use SearchOrFilter;
    //
    public function search( Request $request)
    {
        $all_request = $request->all();

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));

        $model = new SwedishAmericanJubileeRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();

        $result = SwedishAmericanJubileeRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);


        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );

        $keywords = $request->all();



        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
//        return view
        $archive_name = $model::findOrFail(3)->archive;
//        return $model::findOrFail(3)->first()->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();


        return view('dashboard.SwedishAmericanJubileeRecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'enableQueryMatch','defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))
            ->with($request->all());
    }
}
