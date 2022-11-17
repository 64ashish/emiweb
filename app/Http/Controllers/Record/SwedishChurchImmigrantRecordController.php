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
        $carbonize_dates = $this->CarbonizeDates($all_request);
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend(Arr::flatten($carbonize_dates['date_keys']), ['_token', 'action','page']);
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys)));
        $inputQuery=trim(Arr::join( $request->except(Arr::flatten($remove_keys)), ' '));


        $model = new SwedishChurchImmigrantRecord();
        $fieldsToDisply = $model->fieldsToDisply();
        $enableQueryMatch =$model->enableQueryMatch();


        $result = SwedishChurchImmigrantRecord::query();
        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );


        $keywords = $request->all();


        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))->except($defaultColumns )->keys();
        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();


//        return view
        return view('dashboard.SwedishChurchImmigrantRecord.records', compact('records', 'keywords', 'filterAttributes','enableQueryMatch', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());
    }


    public function statics(){
        $provinces = SwedishChurchImmigrantRecord::whereNot('to_county', '  Y')
            ->whereNotNull('to_county')
            ->select('to_county')
            ->distinct()
            ->get()
            ->pluck('to_county','to_county')->prepend('Alla');

        return view('dashboard.SwedishChurchImmigrantRecord.statistics', compact('provinces'));
    }

    public function generateChart( Request $request){

        $data = SwedishChurchImmigrantRecord::findGender($request->sex)
            ->toProvince($request->to_county)
            ->recordDateRange($request->start_year, $request->end_year)
            ->groupRecordsBy($request->group_by)
            ->get();

        $provinces = SwedishChurchImmigrantRecord::whereNot('to_county', '  Y')
            ->whereNotNull('to_county')
            ->select('to_county')
            ->distinct()
            ->get()
            ->pluck('to_county','to_county')->prepend('Alla');

        $title = 'Immigration ' .
            (($request->sex !== "Alla") ? "av $request->sex ": "") .
            (($request->to_county !== "0") ? "från $request->to_county ": "") .
            (($request->start_year != null && $request->end_year == null) ? "år $request->start_year ":"") .
            (($request->start_year != null && $request->end_year != null) && ($request->start_year < $request->end_year ) ? "mellan $request->start_year och $request->end_year" : "")  ;

        $grouped_by = $request->group_by === "to_date"? "year":"to_county";
        $chart_type = $request->chart_type;
        $keywords = $request->all();
        return view('dashboard.SwedishChurchImmigrantRecord.statistics', compact('provinces','data', 'chart_type','title', 'grouped_by','keywords'));
    }

}
