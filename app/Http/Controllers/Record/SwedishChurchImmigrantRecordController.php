<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchImmigrantRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class SwedishChurchImmigrantRecordController extends Controller
{
    use SearchOrFilter;
    //
    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }


    public function search( Request $request )
    {
        $all_request = $request->all();
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action','page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));


        $model = new SwedishChurchImmigrantRecord();
        $fieldsToDisply = $model->fieldsToDisply();


        $result = SwedishChurchImmigrantRecord::query();
        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


        $keywords = $request->all();


        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;

//        return view
        return view('dashboard.SwedishChurchImmigrantRecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());
    }
}
