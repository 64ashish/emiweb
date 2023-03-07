<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\NorthenPacificRailwayCompanyRecord;
use Illuminate\Http\Request;

class NorthenPacificRailwayCompanyRecordController extends Controller
{
    //

    public function browse(NorthenPacificRailwayCompanyRecord $northenPacificRailwayCompanyRecord, $index_letter)
    {
        $archive_name = "Northern Pacific Railway Company";
        $images = $northenPacificRailwayCompanyRecord->where('index_letter', ucwords(trim($index_letter)))->paginate(100);

//        return $images;

        return view('dashboard.NorthPacificRailwayCo.browse', compact('images', 'archive_name'));
    }
}
