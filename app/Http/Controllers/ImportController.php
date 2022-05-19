<?php

namespace App\Http\Controllers;

use App\Imports\DenmarkEmigrationsImport;
use App\Models\Archive;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

//use Maatwebsite\Excel\Excel;

class ImportController extends Controller
{
    //
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function importFromFile(Archive $archive, Request $request)
    {
        $this->authorize('viewAny', $archive);
        $validated = $request->validate([
            'import_file' => 'required|mimes:csv,txt'
        ]);
        if($validated){

            Excel::import(new DenmarkEmigrationsImport, request()->file('import_file'));

            return "task completed successfully";
//
//            try {
//
//
//
//            } catch (Exception $e) {
//
//                $errors = $e;
//                foreach ($errors as $error) {
//                    $error->row(); // row that went wrong
//                }
//            }


        }

    }
}
