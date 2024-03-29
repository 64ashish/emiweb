<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Scout\Engines\MeiliSearchEngine;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;
use MeiliSearch\MeiliSearch;

class DenmarkEmigrationController extends Controller
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


        $all_request = $request->all();


        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));


        $model = new DenmarkEmigration();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();

        $result = DenmarkEmigration::query();
       // dd($all_request);
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );



//        get the keywords again
        $keywords = $request->all();


//        $filterAttributes = $this->meilisearch
//            ->index('denmark_emigrations')
//            ->getFilterableAttributes();

        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());

        $defaultColumns = $model->defaultTableColumns();
//
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
//        return $populated_fields;
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();
        $provinces1 = $this->ProvincesParishes();
        $provincesCoun = array();
        foreach($provinces1 as $key => $value){
            $provincesCoun[$value['code']] = $value['county'];
        }

//        return $model::findOrFail(1)->archive;;
        return view('dashboard.denmarkemigration.records', compact('records', 'keywords','enableQueryMatch', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted','provincesCoun'))->with($request->all());


    }
}
