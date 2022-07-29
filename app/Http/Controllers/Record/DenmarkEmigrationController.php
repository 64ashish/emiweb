<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Scout\Engines\MeiliSearchEngine;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;
use MeiliSearch\MeiliSearch;

class DenmarkEmigrationController extends Controller
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

        $records = DenmarkEmigration::paginate(100);

        return view('home.records', compact('records'));
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
        $detail = DenmarkEmigration::findOrFail($id);
//        return $detail;
        return view('home.denmarkemigration.show', compact('detail'));
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

    public function search( Request $request)
    {

//        return $request->all();

        //        get the input data ready
        $inputFields = $request->except('_token', 'first_name', 'last_name','action' );

        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
        if($request->action === "search")
        {
            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
        }




//        $records = DenmarkEmigration::search($inputQuery, function (Indexes $meilisearch, $query, $options) use ($request){
//            if($request->action === "filter") {
//                if (!empty($request->profession)) {
//                    $options['filter'] = ['profession="' . $request->profession . '"'];
//                }
//                if (!empty($request->birth_place)) {
//                    $options['filter'] = ['birth_place="' . $request->birth_place . '"'];
//                }
//                if (!empty($request->last_resident)) {
//                    $options['filter'] = ['last_resident="' . $request->last_resident . '"'];
//                }
//                if (!empty($request->destination_country)) {
//                    $options['filter'] = ['destination_country="' . $request->destination_country . '"'];
//                }
//                if (!empty($request->destination_city)) {
//                    $options['filter'] = ['destination_city="' . $request->destination_city . '"'];
//                }
//            }
//
//
//
//            return $meilisearch->search($query, $options);
//        })->paginate('100');

        $records = DenmarkEmigration::search($inputQuery,
            function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            run the filter
                if($request->action === "filter") {
                    foreach($inputFields as  $fieldname => $fieldvalue){
                        if(!empty($fieldvalue)) {
                            $options['filter'] = ['"'.$fieldname.'"="' . $fieldvalue . '"'];
                        }
                    }
                }
                return $meilisearch->search($query, $options);
            })->paginate(100);

        $records = DenmarkEmigration::search($inputQuery,
            function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            filter anyway
                foreach($inputFields as  $fieldname => $fieldvalue){
                    if(!empty($fieldvalue)) {
                        $options['filter'] = ['"'.$fieldname.'"="' . $fieldvalue . '"'];
                    }
                }
                return $meilisearch->search($query, $options);
            })->get();

        return $records;

        $keywords = $request->all();

//        return $keywords;

        $filterAttributes = $this->meilisearch->index('denmark_emigrations')->getFilterableAttributes();

        $model = new DenmarkEmigration();



        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(array_filter($request->except(['first_name','last_name','action','_token','query', 'page']), 'strlen'))->except($defaultColumns)->keys();


        return view('dashboard.denmarkemigration.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields'));


    }
}
