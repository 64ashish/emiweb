<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use Illuminate\Http\Request;
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
        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
        if($request->action === "search")
        {
            $inputQuery = $request->first_name." ".$request->last_name." ".$request->profession." ".$request->birth_place." ".$request->last_resident." ".$request->destination_country." ".$request->destination_city;
        }


        $records = DenmarkEmigration::search($inputQuery, function (Indexes $meilisearch, $query, $options) use ($request){
            if($request->action === "filter") {
                if (!empty($request->profession)) {
                    $options['filter'] = ['profession="' . $request->profession . '"'];
                }
                if (!empty($request->birth_place)) {
                    $options['filter'] = ['birth_place="' . $request->birth_place . '"'];
                }
                if (!empty($request->last_resident)) {
                    $options['filter'] = ['last_resident="' . $request->last_resident . '"'];
                }
                if (!empty($request->destination_country)) {
                    $options['filter'] = ['destination_country="' . $request->destination_country . '"'];
                }
                if (!empty($request->destination_city)) {
                    $options['filter'] = ['destination_city="' . $request->destination_city . '"'];
                }
            }



            return $meilisearch->search($query, $options);
        })->get();

        $keywords = $request->all();

        $filterAttributes = $this->meilisearch->index('denmark_emigrations')->getFilterableAttributes();


        return view('home.denmarkemigration.records', compact('records', 'keywords', 'filterAttributes'));


    }
}
