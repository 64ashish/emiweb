<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\DalslanningarBornInAmericaRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class DalslanningarBornInAmericaRecordController extends Controller
{
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
        $detail = DalslanningarBornInAmericaRecordController::findOrFail($id);
        return view('home.dbiar.show', compact('detail'));
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

    public function search( Request $request )
    {
        $inputFields = Arr::whereNotNull($request->except('_token', 'first_name', 'last_name','action' ));

        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
        if($request->action === "search")
        {
            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
        }


        $result = DalslanningarBornInAmericaRecord::search($inputQuery);

        if($request->action === "search"){
            $records = $result->paginate(100);
        }

//      filter the thing and get the results ready
        if($request->action === "filter"){


            $filtered = $result->get();

            foreach($inputFields as  $fieldname => $fieldvalue){
                $filtered =  $filtered->whereIn($fieldname, $fieldvalue);
            }
            $records = $filtered->paginate(100);

        }


        $filterAttributes = $this->meilisearch->index('dalslanningar_born_in_america_records')->getFilterableAttributes();
        $model = new DalslanningarBornInAmericaRecord();
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();

        $advancedFields = $fields->diff($filterAttributes)->flatten();

        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(array_filter($request->except(['first_name','last_name','action','_token','query', 'page']), 'strlen'))->except($defaultColumns)->keys();
        $keywords = $request->all();

        return view('dashboard.dbiar.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields'))->with($request->all());
    }
}

