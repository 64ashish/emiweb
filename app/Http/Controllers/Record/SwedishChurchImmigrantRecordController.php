<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\SwedishChurchImmigrantRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class SwedishChurchImmigrantRecordController extends Controller
{
    use SearchOrFilter;
    //
    public function search( Request $request )
    {



        $all_request = $request->all();

        $quryables = $this->QryableItems($all_request);
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));

        $model = new SwedishChurchImmigrantRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result = SwedishChurchImmigrantRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);

        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


        $keywords = $request->all();

        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();
        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces();


//        return view
        return view('dashboard.SwedishChurchImmigrantRecord.records', compact('records', 'keywords', 'filterAttributes','enableQueryMatch', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted', 'provinces', 'ProvincesParishes'))->with($request->all());
    }


    public function statics()
    {
        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces();

        return view('dashboard.SwedishChurchImmigrantRecord.statistics', compact('provinces','ProvincesParishes'));
    }

    public function generateChart( Request $request){

//        return $request->all();
        $data = SwedishChurchImmigrantRecord::findGender($request->sex)
            ->findProvince($request->birth_county)
            ->findParish($request->birth_parish)
            ->recordDateRange($request->start_year, $request->end_year)
            ->groupRecordsBy($request->group_by)
            ->get();

        if($request->birth_county_compare != null  and $request->chart_type === 'bar')
        {
            $data2 = SwedishChurchImmigrantRecord::findGender($request->sex)
                ->findProvince($request->birth_county_compare)
                ->findParish($request->birth_parish_compare)
                ->recordDateRange($request->start_year, $request->end_year)
                ->groupRecordsBy($request->group_by)
                ->get();

        }else{
            $data2 = null;

        }


//        $provinces = SwedishChurchImmigrantRecord::whereNot('to_county', '  Y')
//            ->whereNotNull('to_county')
//            ->select('to_county')
//            ->distinct()
//            ->get()
//            ->pluck('to_county','to_county')->prepend('Alla');

        if($data2 == null){
            $title = 'Immigration ' .
                (($request->sex !== "Alla") ? "av $request->sex ": "Alla Kön ") .
                (($request->to_county !== "0") ? "från $request->to_county ": "") .
                (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
                (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;
        }else{
            $title = 'Immigration ' .
                (($request->sex !== "Alla") ? "av $request->sex ": "Alla Kön ") .
                (($request->to_county !== "0") ? "från $request->to_county ": "") . ("med $request->to_county_compare ") .
                (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
                (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;
        }

        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces() ;
        $grouped_by = $request->group_by === "to_date"? "year":"to_county";
        $chart_type = $request->chart_type;
        $keywords = $request->all();
        return view('dashboard.SwedishChurchImmigrantRecord.statistics', compact('provinces','data', 'chart_type','title', 'grouped_by','keywords', 'data2','ProvincesParishes'));
    }

}
