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
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action', 'page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));

        $result = SwedishAmericanJubileeRecord::query();

        $records = $this->FilterQuery($inputFields, $result, $all_request);

        $keywords = $request->all();

        $model = new SwedishAmericanJubileeRecord();

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

        return view('dashboard.SwedishAmericanJubileeRecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))
            ->with($request->all());
    }
}
