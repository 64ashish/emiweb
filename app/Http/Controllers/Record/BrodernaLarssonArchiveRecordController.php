<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\BrodernaLarssonArchiveDocument;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class BrodernaLarssonArchiveRecordController extends Controller
{
    use SearchOrFilter;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }


    public function search( Request $request )
    {

        $all_request = $request->all();

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));

        $model = new BrodernaLarssonArchiveRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();

        $result = BrodernaLarssonArchiveRecord::query();

        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


        $keywords = $request->all();
//        return view


        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();

        $advancedFields = $fields->diff($filterAttributes)->flatten();

        $defaultColumns = $model->defaultTableColumns();

        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = Archive::findOrFail(11);
//        return $archive_name;
//        $archive_name = "hello, im blrc";

        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();



        return view('dashboard.larsson.records', compact('records', 'keywords','enableQueryMatch', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields', 'archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());

    }

    public function browseYear(BrodernaLarssonArchiveDocument $brodernaLarssonArchiveDocument)
    {
        $years = $brodernaLarssonArchiveDocument->select('year')->distinct()->get();

        return view('dashboard.larsson.browse',compact('years'));
    }

    public function browseDocuments(BrodernaLarssonArchiveDocument $brodernaLarssonArchiveDocument, $year)
    {
        $documents = $brodernaLarssonArchiveDocument->where('year', trim($year))->paginate(100);
        return view('dashboard.larsson.document', compact('documents','year'));
    }


}
