<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Models\DalslanningarBornInAmericaRecord;
use App\Models\DenmarkEmigration;
use App\Models\Organization;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
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

        switch($archive->id) {
            case(1):
                $records = DenmarkEmigration::with('archive')->paginate(100);
                $viewfile = 'dashboard.denmarkemigration.index';
                break;

            case(18):
                $records = DalslanningarBornInAmericaRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.dbiar.records';
                break;

            case(5):
                $records = SwedishChurchEmigrationRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.swedishchurchemigrationrecord.records';
                break;

            case(9):
                $records = SwedishEmigrationStatisticsRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.scbe.records';
                break;

            case(11):
                $records = BrodernaLarssonArchiveRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.larsson.records';
                break;

            default:
                abort(403);
        }

        return view($viewfile, compact('records', 'organization'));

    }

    public function view(Organization $organization, Archive $archive, $id){


//        check if user has permission
        $this->authorize('view', $archive);

//        if authorized, do the thing

        switch($archive->id) {
            case(1):
                $detail = DenmarkEmigration::findOrFail($id);
                $model = new DenmarkEmigration();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(18):

                $model = new DalslanningarBornInAmericaRecord();
                $detail = DalslanningarBornInAmericaRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $detail = SwedishChurchEmigrationRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $detail = SwedishEmigrationStatisticsRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $detail = BrodernaLarssonArchiveRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('dashboard.show', compact('detail', 'fields', 'archive'));


    }

    public function create( Organization $organization, Archive $archive)
    {
        $this->authorize('create', $archive);

        switch($archive->id) {
            case(1):
                $model = new DenmarkEmigration();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
            break;

            case(18):
                $model = new DalslanningarBornInAmericaRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
            break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
            break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
            break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
            break;

            default:
                abort(403);
        }

        return view('dashboard.create',compact('organization', 'archive',  'fields'));

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

        switch($archive->id) {
            case(1):
                $record = DenmarkEmigration::findOrFail($record);
                $model = new DenmarkEmigration();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(18):

                $model = new DalslanningarBornInAmericaRecord();
                $record = DalslanningarBornInAmericaRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $record = SwedishChurchEmigrationRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $record = SwedishEmigrationStatisticsRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $record = BrodernaLarssonArchiveRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('dashboard.update', compact('record',"organization", "archive", 'fields'));

    }

    public function update(Organization $organization, Archive $archive, $record, Request $request)
    {
        $this->authorize('update', $archive);

        if( $archive->id == 1)
        {

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);



//            if($validated){
//                $denmarkEmigration = DenmarkEmigration::findOrFail($record);
//                $denmarkEmigration->update($request->except(['_token', '_method' ]));
//                return redirect('/dashboard')->with('success', 'Record Updated!');
//            }

        }

        switch($archive->id) {
            case(1):
                $denmarkEmigration = DenmarkEmigration::findOrFail($record);
                $denmarkEmigration->update($request->except(['_token', '_method' ]));
                break;

            case(18):
                $model = new DalslanningarBornInAmericaRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        // if none match, abort
        abort(403);

    }
}
