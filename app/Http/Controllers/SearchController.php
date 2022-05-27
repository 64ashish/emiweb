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
        if($archive == 1){
            $records = Archive::findOrFail($archive)->denmarkEmigrations()->paginate(500);
            return view('home.denmarkemigration.records', compact('records'));
        }

        if($archive == 18){
            $records = Archive::findOrFail($archive)->DalslanningarBornInAmericaRecord()->paginate(500);
//            return $records;
            return view('home.dbiar.records', compact('records'));
        }
//
        if($archive == 5){
            $records = Archive::findOrFail($archive)->SwedishChurchEmigrationRecord()->paginate(500);
//            return $records;
            return view('home.swechurchemi.records', compact('records'));
        }

        if($archive == 9){
            $records = Archive::findOrFail($archive)->SwedishEmigrationStatisticsRecord()->paginate(500);
            return view('home.swestatemi.records', compact('records'));
        }

        if($archive == 11){
            $records = Archive::findOrFail($archive)->BrodernaLarssonArchiveRecords()->paginate(500);
            return view('home.larsson.records', compact('records'));
        }
//        if($archive == 1) {
//            return view('home.denmarkemigration.search');
//        }




    }
    public function search( Request  $request)
    {
        $keywords = $request->search;
        $q1 = DenmarkEmigration::search($keywords)->get()->load('archive');
        $q2 = SwedishChurchEmigrationRecord::search($keywords)->get()->load('archive');
        $q3 = DalslanningarBornInAmericaRecord::search($keywords)->get()->load('archive');
        $q4 = SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');

        if(auth()->user()->hasRole('regular user'))
        {
            $records = $q1;
        }
        else{
            $records = collect([$q1, $q2, $q3, $q4])->flatten();
        }
//            return $records;


//        return SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');
//        return $records ;
        return view('home.results', compact('records', 'keywords'));

    }

    public function show($arch, $id){
//        return $id;
        if($arch == 1)
        {
            $detail = DenmarkEmigration::findOrFail($id);
            return view('home.denmarkemigration.show', compact('detail'));

        }
        if($arch == 5)
        {
            $detail = SwedishChurchEmigrationRecord::findOrFail($id);
            return view('home.swechurchemi.show', compact('detail'));
        }

        if($arch == 18){
            $detail = DalslanningarBornInAmericaRecord::findOrFail($id);
//            return $records;
            return view('home.dbiar.show', compact('detail'));
        }

        if($arch == 9){
            $detail = SwedishEmigrationStatisticsRecord::findOrFail($id);
//            return $detail;
            return view('home.swestatemi.show', compact('detail'));
        }

        if($arch == 11){
            $detail = BrodernaLarssonArchiveRecord::findOrFail($id);
            return view('home.larsson.show', compact('detail'));
        }

    }


}
