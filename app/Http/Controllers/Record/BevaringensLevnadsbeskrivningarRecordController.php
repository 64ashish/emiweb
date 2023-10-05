<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\BevaringensLevnadsbeskrivningarRecord;
use App\Traits\SearchOrFilter;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BevaringensLevnadsbeskrivningarRecordController extends Controller
{
    //
    use SearchOrFilter;

    public function index()
    {
        //

    }

    /**
     * Perform search on the archive
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request )
    {
//        get all request
        $all_request = $request->all();
//      seperate the quryable items
        $quryables = $this->QryableItems($all_request);
//        carbonise all dates
        $carbonize_dates = $this->CarbonizeDates($all_request);
//        merge all carbonised dates
        $request->merge($carbonize_dates['field_data']);
        $remove_keys =Arr::prepend([Arr::flatten($carbonize_dates['date_keys']),$quryables], ['_token', 'action','page'] );
//        pull input fields
        $inputFields = Arr::whereNotNull($request->except(Arr::flatten($remove_keys),$quryables));
//      start query
        $model = new BevaringensLevnadsbeskrivningarRecord();
//        get fields to display
        $fieldsToDisply = $model->fieldsToDisply();
//        get fields to be matched for custom query, the name fields with dropdown
        $enableQueryMatch =$model->enableQueryMatch();

//        perform the search
        $result = BevaringensLevnadsbeskrivningarRecord::query();
        $this->QueryMatch($quryables,$result, $all_request);
        
        $records = $this->FilterQuery($inputFields, $result, $all_request, array_keys($fieldsToDisply) );   

        $keywords = $request->all();


        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $defaultColumns = $model->defaultTableColumns();
        $populated_fields = collect(Arr::except($inputFields, ['first_name', 'last_name']))
            ->except($defaultColumns )->keys();
        $provinces = $this->provinces();

        $archive_name = $model::findOrFail(1)->archive;
        $toBeHighlighted = collect(Arr::except($inputFields, ['first_name', 'last_name']))->keys();

        return view('dashboard.blbrc.records', compact('provinces','records', 'keywords','enableQueryMatch', 'filterAttributes', 'advancedFields', 'defaultColumns','populated_fields','archive_name','fieldsToDisply','toBeHighlighted'))->with($request->all());

    }



}
