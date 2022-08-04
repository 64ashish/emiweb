<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class BrodernaLarssonArchiveRecordController extends Controller
{
    use SearchOrFilter;

    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

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
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=Arr::join( $request->except(Arr::flatten($remove_keys)), ' ');


        if($request->action === "search"){
            $result = BrodernaLarssonArchiveRecord::search($inputQuery);
            $records = $result->paginate(100);
        }

//      filter the thing and get the results ready
        if($request->action === "filter"){
            $melieRaw = BrodernaLarssonArchiveRecord::search($inputQuery,
                function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            run the filter
                    $options['limit'] = 1000000;
                    return $meilisearch->search($query, $options);
                })->raw();
            $idFromResults = collect($melieRaw['hits'])->pluck('id');
            $result = BrodernaLarssonArchiveRecord::whereIn('id', $idFromResults);
//            filter is performed here
            $records = $this->FilterQuery($inputFields, $result, $all_request);

        }
//        get the filter attributes
        $filterAttributes = $this->meilisearch->index('broderna_larsson_archive_records')->getFilterableAttributes();
//        get the keywords again
        $keywords = $request->all();
//        return view

        $model = new BrodernaLarssonArchiveRecord();
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();

        $advancedFields = $fields->diff($filterAttributes)->flatten();

        $defaultColumns = $model->defaultTableColumns();

        $populated_fields = collect($inputFields)->except($defaultColumns)->keys();
        $archive_name = $model::findOrFail(1)->archive->name;

        return view('dashboard.larsson.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name'))->with($request->all());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
