<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Models\NorthenPacificRailwayCompanyRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NorthenPacificRailwayCompanyRecordController extends Controller
{
    //

    public function browse(NorthenPacificRailwayCompanyRecord $northenPacificRailwayCompanyRecord, $index_letter)
    {
        $archive_name = "Northern Pacific Railway Company";
        $images = $northenPacificRailwayCompanyRecord->where('index_letter', ucwords(trim($index_letter)))->paginate(100);
//        $images = $northenPacificRailwayCompanyRecord->where('index_letter', ucwords(trim($index_letter)))->first();

//        $fileName ='archives/25/images/'.$images->index_letter."/".$images->filename;
//
//        $image =  Storage::disk('s3')->temporaryUrl($fileName, now()->addMinutes(10));
//        return "<img src=$image>";

        return view('dashboard.NorthPacificRailwayCo.browse', compact('images', 'archive_name'));
    }
}
