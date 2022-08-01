<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class SwedishChurchEmigrationRecordController extends Controller
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

//        return $request->all();
//        return Carbon::parse($request->dob)->format('Y/m/d');
//        get the input data ready
        $inputFields = Arr::whereNotNull($request->except('_token', 'first_name', 'last_name','action' ));
//        prepare for filter
        $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');

//        return $inputQuery;
//        if($request->action === "filter")
//        {
//            $inputQuery = $request->first_name." ".$request->last_name;
//        }
////        prepare for search
//        if($request->action === "search")
//        {
//            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
//        }

        $result = SwedishChurchEmigrationRecord::search($inputQuery);

        //        get the search result prepared
        if($request->action === "search"){
            $records = $result->paginate(100);
        }

//      filter the thing and get the results ready
        if($request->action === "filter"){


            $melieRaw = SwedishChurchEmigrationRecord::search($inputQuery,
                function (Indexes $meilisearch, $query, $options) use ($request, $inputFields){
//            run the filter
                        $options['limit'] = 10000;
//                        foreach($inputFields as  $fieldname => $fieldvalue) {
////                            if (!(str_contains(str_replace('_', ' ', $fieldname), 'date') or $fieldname !== "dob"))
////                            {
////                                if (!empty($fieldvalue)) {
////                                    $options['filter'] = ['"' . $fieldname . '"="' . $fieldvalue . '"'];
////                                }
////                            }
////                            if (!empty($fieldvalue)) {
////                                $options['filter'] = ['"' . $fieldname . '"="' . $fieldvalue . '"'];
////                            }
//                        }

                    return $meilisearch->search($query, $options);
                })->raw();

            $idFromResults = collect($melieRaw['hits'])->pluck('id');


            $result = SwedishChurchEmigrationRecord::whereIn('id', $idFromResults);

//            return $inputFields ;

            foreach($inputFields as  $fieldname => $fieldvalue) {
//                $records =  $records->where($fieldname,  [$fieldvalue]);

                if((str_contains(str_replace('_', ' ', $fieldname), 'date') or $fieldname === "dob") )
                {

//                    return $filtered->filter(function ($filter ) use ($fieldname,$fieldvalue ) {
//                        return $filter->where($fieldname,Carbon::parse($fieldvalue)->format('Y/m/d'));
//                    });
//                    $filtered =  $filtered->$fieldname->eq(Carbon::parse($fieldvalue)->format('Y/m/d'));
//                    $result = $result->where($fieldname,Carbon::parse($fieldvalue)->format('Y/m/d'));
                     $result->whereDate($fieldname, Carbon::parse($fieldvalue)->format('Y/m/d'));
                }
                $result->where($fieldname, $fieldvalue);

            }
//            return $inputFields;
//            $result->whereDate('dob', '1867/10/21');
            $records = $result->paginate(100);

//            return $idFromResults;



//            $total = $result->paginate(100)->total();
//            return $result->paginate($total*100)->;
//            $filtered = collect($result->paginate($total*100)->get('data'));

//            return $filtered;

//            foreach($inputFields as  $fieldname => $fieldvalue) {
//                $filtered =  $filtered->whereIn($fieldname, $fieldvalue);
//            }




//            return $filtered->where();

//            foreach($inputFields as  $fieldname => $fieldvalue){
//
////                $filtered =  $filtered->where('id',6454);
//                if((str_contains(str_replace('_', ' ', $fieldname), 'date') or $fieldname === "dob") )
//                {
//
////                    return $filtered->filter(function ($filter ) use ($fieldname,$fieldvalue ) {
////                        return $filter->where($fieldname,$fieldvalue);
////                    });
////                    $filtered =  $filtered->$fieldname->eq(Carbon::parse($fieldvalue)->format('Y/m/d'));
//                    $filtered = $filtered->where($fieldname, $fieldvalue);
//
//                }else{
//                    $filtered =  $filtered->whereIn($fieldname, $fieldvalue);
//                }
////                $filtered =  $filtered->whereIn($fieldname, $fieldvalue);
//
//            }

            ;



        }

//        $records = $filtered->paginate(10);
//
//        return $records;





//        get the filter attributes
        $filterAttributes = $this->meilisearch->index('swedish_church_emigration_records')->getFilterableAttributes();
//        get the keywords again
        $keywords = $request->all();

        $model = new SwedishChurchEmigrationRecord();
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(array_filter($request->except(['first_name','last_name','action','_token','query', 'page']), 'strlen'))->except($defaultColumns)->keys();
//        return view
        return view('dashboard.swedishchurchemigrationrecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields'))->with($request->all());
    }
}
