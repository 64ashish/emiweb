<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use App\Traits\FromArchive;

class RelativeController extends Controller
{
    use FromArchive;
    //
    public function create(Request $request, Archive $archive, $id){
        // $archive=> main items's archive id and $id is main item
        $archive_id = explode('/', $request->relative_info)[1];  // archive id of related item
        $item_id = explode('/', $request->relative_info)[3]; // id of related item
        $theItem = $this->RecordIs( $archive_id, $item_id);
        $full_name = $theItem->first_name. " " .$theItem->last_name;
        $data = [
            'full_name'=> $full_name,
            'relationship_type'=> $request->relationship_type,
            'record_id'=> $id,
            'item_id'=> $item_id,
            'archive'=> $archive_id,
        ];
        $archive->relatives()->create($data);

        return redirect()->back();
    }
}
