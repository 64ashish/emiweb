<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\DenmarkEmigration;
use App\Models\Organization;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationArchiveController extends Controller
{
    //

    public function index()
    {
        return "get all archive";
    }



    public function ShowRecords(Organization $organization, Archive $archive){




        $this->authorize('viewAny', $archive);
//// Den danska emigrantdatabasen
//        if( $archive->id == 1)
//        {
//            $records = DenmarkEmigration::paginate(100);
//            return view('dashboard.denmarkemigration.index', compact('records', 'organization'));
//        }
//// Emigranter registrerade i svenska kyrkböcker
//        if( $archive->id == 5)
//        {
//            $records = SwedishChurchEmigrationRecord::paginate(100);
////            return $records;
//            return view('dashboard.swedishchurchemigrationrecord.index', compact('records', 'organization'));
//        }
//        if( $archive->id == 9)
//        {
//            $records = SwedishChurchEmigrationRecord::paginate(100);
////            return $records;
//            return view('dashboard.scbe.records', compact('records', 'organization'));
//        }


        if($archive->id == 1){
//            $records = Archive::findOrFail($archive->id)->denmarkEmigrations()->paginate(500);
//            return view('home.denmarkemigration.records', compact('records'));
                        $records = DenmarkEmigration::paginate(100);
            return view('dashboard.denmarkemigration.index', compact('records', 'organization'));
        }

        if($archive->id == 18){
            $records = Archive::findOrFail($archive->id)->DalslanningarBornInAmericaRecord()->paginate(500);
//            return $records;
            return view('home.dbiar.records', compact('records'));
        }
//
        if($archive->id == 5){
            $records = Archive::findOrFail($archive->id)->SwedishChurchEmigrationRecord()->paginate(500);
//            return $records;
            return view('home.swechurchemi.records', compact('records'));
        }

        if($archive->id == 9){
            $records = Archive::findOrFail($archive->id)->SwedishEmigrationStatisticsRecord()->paginate(500);
            return view('home.swestatemi.records', compact('records'));
        }

        if($archive->id == 11){
            $records = Archive::findOrFail($archive->id)->BrodernaLarssonArchiveRecords()->paginate(500);
            return view('home.larsson.records', compact('records'));
        }
        abort(403);

    }

    public function view(Organization $organization, Archive $archive, $id){


//        check if user has permission
        $this->authorize('view', $archive);
//        display the details
        // Den danska emigrantdatabasen
        if( $archive->id == 1)
        {
            $detail = DenmarkEmigration::findOrFail($id);
            return view('dashboard.denmarkemigration.show', compact('detail'));
        }

        // Emigranter registrerade i svenska kyrkböcker
        if( $archive->id == 5)
        {
            $detail = SwedishChurchEmigrationRecord::findOrFail($id);

//            foreach($detail as $key=>$value)
//            {
//                echo str_replace("_", ' ', $key)." : ".$value. "<br>";
//            }


            return view('dashboard.swedishchurchemigrationrecord.show', compact('detail'));

        }
        abort(403);


    }

    public function create( Organization $organization, Archive $archive)
    {
        $this->authorize('create', $archive);

        if( $archive->id == 1)
        {
            return view('dashboard.denmarkemigration.create', compact("organization", "archive"));
        }

        // if none match, abort
        abort(403);

    }

    public function store( Organization $organization, Archive $archive, Request $request)
    {

        $this->authorize('create', $archive);

        if( $archive->id == 1)
        {

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'secrecy' => 'required',
                'travel_type' => 'required'
            ]);

            if($validated){

                $request->merge([
                    'user_id' => auth()->user()->id,
                    'organization_id' => auth()->user()->organization_id
                ]);

                $archive->denmarkEmigrations()->create($request->all());
                return redirect('/dashboard')->with('success', 'New record created!');
            }


        }

        // if none match, abort
        abort(403);

    }

    public function edit(Organization $organization, Archive $archive, $record)
    {
        $this->authorize('update', $archive);
        if( $archive->id == 1)
        {
            $record = DenmarkEmigration::findOrFail($record);
//            return $record;
            return view('dashboard.denmarkemigration.update', compact('record',"organization", "archive"));
        }
    }

    public function update(Organization $organization, Archive $archive, $record, Request $request)
    {
        $this->authorize('update', $archive);

        if( $archive->id == 1)
        {

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'secrecy' => 'required',
                'travel_type' => 'required'
            ]);
            if($validated){
                $denmarkEmigration = DenmarkEmigration::findOrFail($record);
                $denmarkEmigration->update($request->except(['_token', '_method' ]));
                return redirect('/dashboard')->with('success', 'Record Updated!');
            }

        }

        // if none match, abort
        abort(403);

    }
}
