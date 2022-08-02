<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;
use Psr\Log\NullLogger;

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

        $r = array_intersect_key(Arr::whereNotNull($request->all()),
            array_flip(preg_grep('/^array_/', array_keys(Arr::whereNotNull($request->all())))));

        $date_keys = [];




        foreach($r as $r => $dates){

            $date_keys[] = $r;
            if(count(Arr::whereNotNull(Arr::flatten($dates))) > 0){
                $field = Str::of($r)->after('array_');
                $year = !is_null($dates['year'])?$dates['year']:"0001";
                $month = !is_null($dates['month'])?$dates['month']:"01";
                $day = !is_null($dates['day'])?$dates['day']:"01";
                $request->merge([ "$field" => $year."/".$month."/".$day]);
            }

        }

        $remove_keys =Arr::prepend(Arr::flatten($date_keys), ['_token', 'action']);
        $remove_keys_for_inputs = Arr::prepend(Arr::flatten($date_keys), ['_token', 'action' ]);


        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys_for_inputs)));

//        return $date_keys;




        if($request->action === "filter")
        {
//            $inputQuery = $request->first_name." ".$request->last_name;
            $inputQuery="";
        }
//        prepare for search
        if($request->action === "search")
        {
            $inputQuery = Arr::join( $request->except(Arr::flatten($remove_keys)), ' ');
        }



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
                    return $meilisearch->search($query, $options);
                })->raw();

//            return $melieRaw;

            $idFromResults = collect($melieRaw['hits'])->pluck('id');


            $result = SwedishChurchEmigrationRecord::whereIn('id', $idFromResults);

//            return $inputFields ;

            $inputs_for_filter = $request->except( ['_token', 'first_name', 'last_name','action' ]);
//
//            return $inputs_for_filter;

            foreach($inputFields as  $fieldname => $fieldvalue) {
//                $records =  $records->where($fieldname,  [$fieldvalue]);

//                echo $r;

                if(!(str_contains(str_replace('_', ' ', $fieldname), 'date') or !str_contains(str_replace('_', ' ', $fieldname), 'dob') ) )
                {
//
//                    echo $fieldvalue;
                   $date_to_filter = Carbon::createFromFormat('Y/m/d', $fieldvalue);
                   if($date_to_filter->dayOfYear != 1)
                   {
                       $result->whereDate($fieldname, Carbon::parse($fieldvalue)->format('Y/m/d'));
                   }
                   else{
                       $result->whereYear($fieldname, Carbon::createFromFormat('Y/m/d', $fieldvalue));
                   }
                }else{
                    $result->where($fieldname, $fieldvalue);
                }

//

            }
//            exit;
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
//        $populated_fields = collect($request->except(['first_name','last_name','action','_token','query', 'page']))->except($defaultColumns)->keys();
        $populated_fields = collect($inputFields)->except($defaultColumns)->keys();
//        return $populated_fields;
//        return view
        return view('dashboard.swedishchurchemigrationrecord.records', compact('records', 'keywords', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields'))->with($request->all());
    }
}
