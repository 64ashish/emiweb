<?php

namespace App\Http\Controllers;

use App\Exports\DenmarkEmigrationsExport;
use App\Models\Archive;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    //

    public function exportToFile(Archive $archive)
    {
        $this->authorize('viewAny', $archive);
        if($archive->id == 1)
        {
            return Excel::download(new DenmarkEmigrationsExport(), 'Den danska emigrantdatabasen.xlsx');
        }
    }
}
