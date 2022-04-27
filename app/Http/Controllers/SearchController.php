<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\DenmarkEmigration;
use App\Models\SwedishChurchEmigrationRecord;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index($archive)
    {
        if($archive == 1){
            $records = Archive::findOrFail($archive)->denmarkEmigrations()->paginate(100);
        }

        if($archive == 5){
            $records = Archive::findOrFail($archive)->SwedishChurchEmigrationRecord()->paginate(100);
        }


        return view('home.records', compact('records'));

    }
    public function search( Request  $request)
    {
        $keywords = $request->search;
        $q1 = DenmarkEmigration::search($keywords)->get()->load('archive');
//        return $q1;
        $q2 = SwedishChurchEmigrationRecord::search($keywords)->get()->load('archive');
        $records = $q1->union($q2);
        return view('home.results', compact('records', 'keywords'));

    }

    public function show($arch, $id){
//        return $id;
        if($arch == 1)
        {
            $detail = DenmarkEmigration::findOrFail($id);
            return view('home.showrecord', compact('detail'));

        }
        if($arch == 5)
        {
            $detail = SwedishChurchEmigrationRecord::findOrFail($id);
            return view('home.swedish-church-emigration', compact('detail'));
        }

    }


}
