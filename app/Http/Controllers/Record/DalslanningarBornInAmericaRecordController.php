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
        $inputFields = $request->except('_token', 'first_name', 'last_name','action' );

        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
        if($request->action === "search")
        {
            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
        }


        $records = DalslanningarBornInAmericaRecord::search($inputQuery,
            function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
                if($request->action === "filter") {
                    foreach($inputFields as  $fieldname => $fieldvalue){
                        if(!empty($fieldvalue)) {
                            $options['filter'] = ['"'.$fieldname.'"="' . $fieldvalue . '"'];
                        }
                    }
                }

                return $meilisearch->search($query, $options);
            })->paginate();


        $filterAttributes = $this->meilisearch->index('dalslanningar_born_in_america_records')->getFilterableAttributes();
        $keywords = $request->all();

        return view('dashboard.dbiar.records', compact('records',  'keywords','filterAttributes'))->with($request->all());
    }
}

