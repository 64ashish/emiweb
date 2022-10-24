<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use App\Traits\SearchOrFilter;
use Psr\Log\NullLogger;

class SwedishChurchEmigrationRecordController extends Controller
{
    use SearchOrFilter;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function search( Request $request )
    {


        $all_request = $request->all();
//        return $all_request;
        $carbonize_dates = $this->CarbonizeDates($all_request);
//        return $carbonize_dates;
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action','page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
//        return $inputFields;
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));
//        return $inputQuery;
        $model = new SwedishChurchEmigrationRecord();
        $fieldsToDisply = $model->fieldsToDisply();

        $result = SwedishChurchEmigrationRecord::query();


        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


//        return $fieldsToDisply;




        $keywords = $request->all();



        $filterAttributes = collect($model->defaultSearchFields());
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();


        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
//        return $defaultColumns;
        $archive_name = $model::findOrFail(1)->archive;




        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();

        return view('dashboard.swedishchurchemigrationrecord.records',
            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name', 'fieldsToDisply','toBeHighlighted'))->with($request->all());
//        return view('dashboard.swedishchurchemigrationrecord.alp',
//            compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());
    }
}
