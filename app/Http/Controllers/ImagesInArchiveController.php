<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;

class ImagesInArchiveController extends Controller
{
    //

    public function create(Request $request, Archive $archive, $id)
    {

        $data =  $request->all() + ['collection_id'=>explode('/', $request->image_name)[1],'record_id'=>$id];

        $archive->ImagesInArchive()->create($data);

        return redirect()->back();

    }
}
