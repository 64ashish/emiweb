<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\ScercDocumentRecord;
use App\Models\ScercPhotoRecord;
use App\Models\SwedishChurchEmigrationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Traits\SearchOrFilter;
use Psr\Log\NullLogger;

class SwedishChurchEmigrationRecordController extends Controller
{
    use SearchOrFilter;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */



//    public function search( Request $request )
//    {
//
//        $all_request = $request->all();
//        $model = new SwedishChurchEmigrationRecord();
//
//        $quryables = $this->QryableItems($all_request);
//
//        $carbonize_dates = $this->CarbonizeDates($all_request);
//
//        $request->merge($carbonize_dates['field_data']);
//
//        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page','compare_dob','compare_dob_check'] );
//        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));
//
//
//
//        $fieldsToDisply = $model->fieldsToDisply();
//
//
//        $result = SwedishChurchEmigrationRecord::query();
//
//        $this->QueryMatch($quryables,$result, $all_request);
//
//        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );
//
////        return $records;$records
//
//        $keywords = $request->all();
//
////        return $keywords;
//
//
//        $enableQueryMatch =$model->enableQueryMatch();
//        $filterAttributes = collect($model->defaultSearchFields());
//        $advancedFields = collect($model->searchFields());
//        $defaultColumns = $model->defaultTableColumns();
//        $archive_name = $model::findOrFail(1)->archive;
//
//
//
//        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name',]))->except($defaultColumns )->keys();
////        return $defaultColumns;
//
//
//        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();
//        $ProvincesParishes = collect($this->ProvincesParishes());
//        $provinces = $this->provinces();
//
////        eventually replace with
//        $genders = $this->getGender();
////        return $gender;
//
//        return view('dashboard.swedishchurchemigrationrecord.records', compact(
//            'records',
//            'keywords',
//            'filterAttributes',
//            'advancedFields',
//            'defaultColumns',
//            'populated_fields',
//            'archive_name',
//            'fieldsToDisply',
//            'toBeHighlighted',
//            'enableQueryMatch',
//            'provinces',
//            'genders',
//            'ProvincesParishes'))->with($request->all());
//
//    }

    public function search( Request $request )
    {
//        return $request->all();
        // Initialize variables
        $all_request = $request->all();
        $model = new SwedishChurchEmigrationRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch = $model->enableQueryMatch();
        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $archive_name = $model::findOrFail(1)->archive;
        // retrive from trait
        $genders = $this->getGender();
        $provinces = $this->provinces();
        $ProvincesParishes = collect($this->ProvincesParishes());

        // Modify request data
        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys = Arr::prepend(
            [
                Arr::flatten($carbonize_dates['date_keys']),
                $quryables
            ],
            [
                '_token', 'action','page','compare_dob','compare_dob_check'
            ]
        );
        $inputFields = Arr::whereNotNull(
            $request->except(
                Arr::flatten($remove_keys),
                $quryables
            )
        );

        // Perform search
        $result = SwedishChurchEmigrationRecord::query();
        $this->QueryMatch($quryables, $result, $all_request);
        $records = $this->FilterQuery(
            $inputFields,
            $result,
            $all_request,
            array_keys($fieldsToDisply)
        );

//        return $result;
        // Extract variables for view
        $keywords = $request->all();
        $populated_fields = collect(
            Arr::except(
                $inputFields,
                ['first_name', 'last_name']
            )
        )->except($defaultColumns)->keys();
        $toBeHighlighted = collect(
            Arr::except(
                $inputFields,
                ['first_name', 'last_name']
            )
        )->keys();

//        return $keywords;

//        return $archive_name;
        // Render view
        return view('dashboard.swedishchurchemigrationrecord.records', compact(
            'records',
            'keywords',
            'filterAttributes',
            'advancedFields',
            'defaultColumns',
            'populated_fields',
            'archive_name',
            'fieldsToDisply',
            'toBeHighlighted',
            'enableQueryMatch',
            'provinces',
            'genders',
            'ProvincesParishes'
        ))->with($request->all());
    }


    public function statics(){

        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces() ;

        return view('dashboard.swedishchurchemigrationrecord.statistics', compact('provinces','ProvincesParishes'));

    }

    public function generateChart( Request $request)
    {

        $data = SwedishChurchEmigrationRecord::findGender($request->gender)
                ->fromProvince($request->from_province)
                ->fromParish($request->from_parish)
                ->recordDateRange($request->start_year,$request->end_year)
                ->groupRecordsBy($request->group_by)
                ->get();
        if($request->from_province_compare != null and $request->chart_type === 'bar')
        {
            $data2 = SwedishChurchEmigrationRecord::findGender($request->gender)
                ->fromProvince($request->from_province_compare)
                ->fromParish($request->from_parish_compare)
                ->recordDateRange($request->start_year,$request->end_year)
                ->groupRecordsBy($request->group_by)
                ->get();

        }else{
            $data2 = null;
        }


        if($data2 == null){
            $title = 'Emigration ' .
                (($request->gender !== "Alla") ? "av $request->gender ": "alla kön ") .
                (($request->from_province !== "0") ? "från $request->from_province ": "") .
                (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
                (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;
        }else{
            $title = 'Jämförelseområde Emigration ' .
                (($request->gender !== "Alla") ? "av $request->gender ": "alla kön ") .
                (($request->from_province !== "0") ? "från $request->from_province ": "") . ("med $request->from_province_compare ") .
                (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
                (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;
        }



//        return $data;
        $grouped_by = $request->group_by === "record_date"? "year":"from_province";
        $chart_type = $request->chart_type;
        $keywords = $request->all();


        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces() ;

        return view('dashboard.swedishchurchemigrationrecord.statistics', compact('provinces','ProvincesParishes','data','data2', 'chart_type','title', 'grouped_by','keywords'));
    }


    public function searchPhotos()
    {
        return view('dashboard.swedishchurchemigrationrecord.photos');
    }

    public function resultPhotos(Request $request)
    {
        $keywords = array_filter( $request->except('_token','page'));

        $query = ScercPhotoRecord::query();

        foreach($keywords as $fieldName => $value)
        {

            if(  $fieldName === 'title' or $fieldName==='description')
            {
                $query->where($fieldName,'like', '%'. $value .'%');
            }
            if( $fieldName !== 'title' and $fieldName !=='description')
            {
                $query->where($fieldName, $value);
            }
        }

        $records = $query->paginate(100)->withQueryString();

//        return $records->total();
        return view('dashboard.swedishchurchemigrationrecord.photos',
            compact('records'));
    }

    public function searchDocuments(){
        $types = [
            'Foto' => 'Foto',
            'Frågelista' => 'Frågelista',
            'Tidningsnotis' => 'Tidningsnotis',
            'Annat dokument' =>'Annat dokument',
            'Berättelse' => 'Berättelse',
            'Släktutredning' => 'Släktutredning',
            'Föremål' => 'Föremål',
            'Bok' => 'Bok',
            'Film' => 'Film',
            'Brev' => 'Brev',
            'Övrigt' => 'Övrigt',
            'Vykort' => 'Vykort',
            'Kontrakt' => 'Kontrakt',
            'Tidning' => 'Tidning',
            'Enkätundersökning' => 'Enkätundersökning',
            'Boknotis' => 'Boknotis',
            'Email' => 'Email'
        ];
    }
    public function resultDocuments(Request $request){
        $keywords = array_filter( $request->except('_token'));
        $query = ScercDocumentRecord::query();
        $types = [
            'Foto' => 'Foto',
            'Frågelista' => 'Frågelista',
            'Tidningsnotis' => 'Tidningsnotis',
            'Annat dokument' =>'Annat dokument',
            'Berättelse' => 'Berättelse',
            'Släktutredning' => 'Släktutredning',
            'Föremål' => 'Föremål',
            'Bok' => 'Bok',
            'Film' => 'Film',
            'Brev' => 'Brev',
            'Övrigt' => 'Övrigt',
            'Vykort' => 'Vykort',
            'Kontrakt' => 'Kontrakt',
            'Tidning' => 'Tidning',
            'Enkätundersökning' => 'Enkätundersökning',
            'Boknotis' => 'Boknotis',
            'Email' => 'Email'
            ];

        foreach($keywords as $fieldName => $value)
        {

            if($fieldName==='description')
            {
                $query->whereFullText($fieldName, $value);
            }
            if($fieldName !=='description')
            {
                $query->where($fieldName, $value);
            }
        }

        $records = $query->paginate(100);


    }
}
