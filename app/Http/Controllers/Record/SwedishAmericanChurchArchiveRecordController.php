<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishAmericanChurchArchiveRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

class SwedishAmericanChurchArchiveRecordController extends Controller
{
    //
    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

    public function search( Request $request )
    {

//        SwedishAmericanChurchArchiveRecord::where('gender', 'K')->update(['gender'=> 'female']);
//        SwedishAmericanChurchArchiveRecord::where('gender', 'M')->update(['gender'=> 'male']);
//        return "done";

        $inputFields = $request->except('_token', 'first_name', 'last_name','action' );



        if($request->action === "filter")
        {
            $inputQuery = $request->first_name." ".$request->last_name;
        }
        if($request->action === "search")
        {

            $inputQuery = Arr::join( $request->except('_token', 'action'), ' ');
        }

        foreach($inputFields as  $fieldname => $fieldvalue){
            if(!empty($fieldvalue)) {
                echo $fieldname." - ". $fieldvalue.", ";
            }
        }


        $records = SwedishAmericanChurchArchiveRecord::search($inputQuery,
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


        $filterAttributes = $this->meilisearch->index('swedish_american_church_archive_records')->getFilterableAttributes();
        $keywords = $request->all();

        return view('dashboard.SwedishAmericanChurchArchiveRecord.records', compact('records',  'keywords','filterAttributes'))->with($request->all());
    }
}
