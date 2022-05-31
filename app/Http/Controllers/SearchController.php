<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Models\DalslanningarBornInAmericaRecord;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index($archive)
    {
        switch($archive) {
            case(1):
                $records = DenmarkEmigration::with('archive')->paginate(100);
                $viewfile = 'home.denmarkemigration.records';
                break;

            case(18):
                $records = DalslanningarBornInAmericaRecord::with('archive')->paginate(500);
                $viewfile = 'home.dbiar.records';
                break;

            case(5):
                $records = SwedishChurchEmigrationRecord::with('archive')->paginate(500);
                $viewfile = 'home.swechurchemi.records';
                break;

            case(9):
                $records = SwedishEmigrationStatisticsRecord::with('archive')->paginate(500);
                $viewfile = 'home.swestatemi.records';
                break;

            case(11):
                $records = BrodernaLarssonArchiveRecord::with('archive')->paginate(500);
                $viewfile = 'home.larsson.records';
                break;
            default:
                abort(403);
        }

        return view($viewfile, compact('records'));



    }
    public function search( Request  $request)
    {
        $keywords = $request->search;
        $q1 = DenmarkEmigration::search($keywords)->get()->load('archive');


        if(auth()->user()->hasRole('regular user'))
        {
            $records = $q1;
        }
        else{
            $q2 = SwedishChurchEmigrationRecord::search($keywords)->get()->load('archive');
            $q3 = DalslanningarBornInAmericaRecord::search($keywords)->get()->load('archive');
            $q4 = SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');
            $q5 = BrodernaLarssonArchiveRecord::search($keywords)->get()->load('archive');
            $records = collect([$q1, $q2, $q3, $q4, $q5])->flatten();
        }
//        return DenmarkEmigration::search($keywords)->get()->load('archive');


//        return SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');
//        return $records ;
        return view('home.results', compact('records', 'keywords'));

    }

    public function show($arch, $id){
//        return $id;
//        if($arch == 1)
//        {
//            $detail = DenmarkEmigration::findOrFail($id);
//            return view('home.denmarkemigration.show', compact('detail'));
//
//        }
//        if($arch == 5)
//        {
//            $detail = SwedishChurchEmigrationRecord::findOrFail($id);
//            return view('home.swechurchemi.show', compact('detail'));
//        }
//
//        if($arch == 18){
//            $detail = DalslanningarBornInAmericaRecord::findOrFail($id);
////            return $records;
//            return view('home.dbiar.show', compact('detail'));
//        }
//
//        if($arch == 9){
//            $detail = SwedishEmigrationStatisticsRecord::findOrFail($id);
////            return $detail;
//            return view('home.swestatemi.show', compact('detail'));
//        }
//
//        if($arch == 11){
//            $detail = BrodernaLarssonArchiveRecord::findOrFail($id);
//            return view('home.larsson.show', compact('detail'));
//        }

        switch($arch) {
            case(1):
                $detail = DenmarkEmigration::findOrFail($arch);
                $model = new DenmarkEmigration();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(18):

                $model = new DalslanningarBornInAmericaRecord();
                $detail = DalslanningarBornInAmericaRecord::findOrFail($arch);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $detail = SwedishChurchEmigrationRecord::findOrFail($arch);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $detail = SwedishEmigrationStatisticsRecord::findOrFail($arch);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $detail = BrodernaLarssonArchiveRecord::findOrFail($arch);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('home.showrecord', compact('detail', 'fields'));

    }


}
