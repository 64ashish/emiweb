<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use Illuminate\Http\Request;
use Laravel\Scout\Engines\MeiliSearchEngine;
use MeiliSearch\MeiliSearch;

class DenmarkEmigrationController extends Controller
{
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


        $results = DenmarkEmigration::search($request->first_name." ".$request->last_name." ".$request->profession." ".$request->birth_place." ".$request->last_resident." ".$request->destination_country." ".$request->destination_city);

        $keywords = $request->all();
        /**
        if (!empty($request->profession)) {
            $results->where('profession',  'LIKE', '%'. $request->profession . '%');
         }
        if (!empty($request->birth_place)) {
            $results->where('birth_place', 'LIKE', '%'. $request->birth_place . '%');
        }
        if (!empty($request->last_resident)) {
            $results->where('last_resident', 'LIKE', '%'. $request->last_resident . '%');
        }
        if (!empty($request->destination_country)) {
            $results->where('destination_country', 'LIKE', '%'. $request->destination_country . '%');
        }
        if (!empty($request->destination_city)) {
            $results->where('destination_city', 'LIKE', '%'. $request->destination_city . '%');
        }
 **/

        $records =  $results->get();


        return view('home.denmarkemigration.records', compact('records', 'keywords'));


    }
}
