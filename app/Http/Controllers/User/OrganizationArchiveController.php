<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Models\DalslanningarBornInAmericaRecord;
use App\Models\DenmarkEmigration;
use App\Models\IcelandEmigrationRecord;
use App\Models\JohnEricssonsArchiveRecord;
use App\Models\LarssonEmigrantPopularRecord;
use App\Models\MormonShipPassengerRecord;
use App\Models\NewYorkPassengerRecord;
use App\Models\NorwayEmigrationRecord;
use App\Models\NorwegianChurchImmigrantRecord;
use App\Models\Organization;
use App\Models\SwedeInAlaskaRecord;
use App\Models\SwedishAmericanChurchArchiveRecord;
use App\Models\SwedishAmericanMemberRecord;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishChurchImmigrantRecord;
use App\Models\SwedishEmigrantViaKristianiaRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
use App\Models\SwedishImmigrationStatisticsRecord;
use App\Models\SwedishPortPassengerListRecord;
use App\Models\User;
use App\Models\VarmlandskaNewspaperNoticeRecord;
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

            case(2):
                $records = SwedishAmericanChurchArchiveRecord::with('archive')->paginate(100);
                $viewfile = 'dashboard.SwedishAmericanChurchArchiveRecord.records';
                break;

            case(3):
                $records = NewYorkPassengerRecord::with('archive')->paginate(100);
                $viewfile = 'dashboard.NewYorkPassengerRecord.records';
                break;

            case(4):
                $records = SwedishPortPassengerListRecord::with('archive')->paginate(100);
                $viewfile = 'dashboard.SwedishPortPassengerListRecord.records';
                break;

            case(5):
                $records = SwedishChurchEmigrationRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.swedishchurchemigrationrecord.index';
                break;

            case(6):
                $records = SwedishChurchImmigrantRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.SwedishChurchImmigrantRecord.records';
                break;

            case(7):
                $records = SwedishEmigrantViaKristianiaRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.SwedishChurchImmigrantRecord.records';
                break;

            case(8):
                $records = SwedishImmigrationStatisticsRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.SwedishImmigrationStatisticsRecord.records';
                break;

            case(9):
                $records = SwedishEmigrationStatisticsRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.scbe.records';
                break;

            case(10):
                $records = LarssonEmigrantPopularRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.LarssonEmigrantPopularRecord.records';
                break;

            case(11):
                $records = BrodernaLarssonArchiveRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.larsson.records';
                break;

            case(12):
                $records = JohnEricssonsArchiveRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.JohnEricssonsArchiveRecord.records';
                break;

            case(13):
                $records = NorwegianChurchImmigrantRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.NorwegianChurchImmigrantRecord.records';
                break;

            case(14):
                $records = MormonShipPassengerRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.MormonShipPassengerRecord.records';
                break;

            case(15):
                $records = SwedishAmericanMemberRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.SwedishAmericanMemberRecord.records';
                break;

            case(16):
                $records = SwedeInAlaskaRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.SwedeInAlaskaRecord.records';
                break;

            case(17):
                $records = VarmlandskaNewspaperNoticeRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.VarmlandskaNewspaperNoticeRecord.records';
                break;

            case(18):
                $records = DalslanningarBornInAmericaRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.dbiar.records';
                break;

            case(20):
                $records = NorwayEmigrationRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.norwayemigrationrecord.records';
                break;

            case(21):
                $records = IcelandEmigrationRecord::with('archive')->paginate(500);
                $viewfile = 'dashboard.IcelandEmmigrationRecord.records';
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

            case(2):
                $detail = SwedishAmericanChurchArchiveRecord::findOrFail($id);
                $model = new SwedishAmericanChurchArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(3):
                $detail = NewYorkPassengerRecord::findOrFail($id);
                $model = new NewYorkPassengerRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(4):
                $detail = SwedishPortPassengerListRecord::findOrFail($id);
                $model = new SwedishPortPassengerListRecord();
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

            case(6):
//                fix all date values for this table
                $model = new SwedishChurchImmigrantRecord();
                $detail = SwedishChurchImmigrantRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(7):
                $model = new SwedishEmigrantViaKristianiaRecord();
                $detail = SwedishEmigrantViaKristianiaRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(8):
                $model = new SwedishImmigrationStatisticsRecord();
                $detail = SwedishImmigrationStatisticsRecord::findOrFail($id);
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

            case(10):
                $model = new LarssonEmigrantPopularRecord();
                $detail = LarssonEmigrantPopularRecord::findOrFail($id);
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

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $detail = JohnEricssonsArchiveRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(13):
                $model = new NorwegianChurchImmigrantRecord();
                $detail = NorwegianChurchImmigrantRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(14):
                $model = new MormonShipPassengerRecord();
                $detail = MormonShipPassengerRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(15):
                $model = new SwedishAmericanMemberRecord();
                $detail = SwedishAmericanMemberRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(16):
                $model = new SwedeInAlaskaRecord();
                $detail = SwedeInAlaskaRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(17):
                $model = new VarmlandskaNewspaperNoticeRecord();
                $detail = VarmlandskaNewspaperNoticeRecord::findOrFail($id);
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

            case(20):

                $model = new NorwayEmigrationRecord();
                $detail = NorwayEmigrationRecord::findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(21):

                $model = new IcelandEmigrationRecord();
                $detail = IcelandEmigrationRecord::findOrFail($id);
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

            case(2):
                $model = new SwedishAmericanChurchArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(3):
                $model = new NewYorkPassengerRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(4):

                $model = new SwedishPortPassengerListRecord();
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

            case(6):
                $model = new SwedishChurchImmigrantRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(7):
                $model = new SwedishEmigrantViaKristianiaRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(8):
                $model = new SwedishImmigrationStatisticsRecord();
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

            case(10):
                $model = new LarssonEmigrantPopularRecord();
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

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;


            case(13):
                $model = new NorwegianChurchImmigrantRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(14):
                $model = new MormonShipPassengerRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(15):
                $model = new SwedishAmericanMemberRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(16):
                $model = new SwedeInAlaskaRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(17):
                $model = new VarmlandskaNewspaperNoticeRecord();
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


            case(20):

                $model = new NorwayEmigrationRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(21):

                $model = new IcelandEmigrationRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('dashboard.create',compact('organization', 'archive',  'fields'));

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

            case(2):
                $record = SwedishAmericanChurchArchiveRecord::findOrFail($record);
                $model = new SwedishAmericanChurchArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(3):
                $record = NewYorkPassengerRecord::findOrFail($record);
                $model = new NewYorkPassengerRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(4):
                $record = SwedishPortPassengerListRecord::findOrFail($record);
                $model = new SwedishPortPassengerListRecord();
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

            case(6):
                $model = new SwedishChurchImmigrantRecord();
                $record = SwedishChurchImmigrantRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(7):
                $model = new SwedishEmigrantViaKristianiaRecord();
                $record = SwedishEmigrantViaKristianiaRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(8):
                $model = new SwedishImmigrationStatisticsRecord();
                $record = SwedishImmigrationStatisticsRecord::findOrFail($record);
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

            case(10):
                $model = new LarssonEmigrantPopularRecord();
                $record = LarssonEmigrantPopularRecord::findOrFail($record);
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

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $record = JohnEricssonsArchiveRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(13):
                $model = new NorwegianChurchImmigrantRecord();
                $record = NorwegianChurchImmigrantRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(14):
                $model = new MormonShipPassengerRecord();
                $record = MormonShipPassengerRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(15):
                $model = new SwedishAmericanMemberRecord();
                $record = SwedishAmericanMemberRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(16):
                $model = new SwedeInAlaskaRecord();
                $record = SwedeInAlaskaRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(17):
                $model = new VarmlandskaNewspaperNoticeRecord();
                $record = VarmlandskaNewspaperNoticeRecord::findOrFail($record);
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

            case(20):
                $model = new NorwayEmigrationRecord();
                $record = NorwayEmigrationRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(21):
                $model = new IcelandEmigrationRecord();
                $record = IcelandEmigrationRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('dashboard.update', compact('record',"organization", "archive", 'fields'));

    }

    public function store( Organization $organization, Archive $archive, Request $request)
    {

        $this->authorize('create', $archive);

            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

        if($validated) {
            switch ($archive->id) {
                case(1):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->denmarkEmigrations()->create($request->all());
                    break;
//                    add last_name1 in validation for this to work
                case(2):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishAmericanChurchArchiveRecords()->create($request->all());
                    break;

                case(3):
//                    update given name and surname to first and last names
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->NewYorkPassengerRecords()->create($request->all());
                    break;

                case(4):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishPortPassengerListRecords()->create($request->all());
                    break;



                case(5):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishChurchEmigrationRecord()->create($request->all());
                    break;

                case(6):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishChurchImmigrantRecords()->create($request->all());
                    break;

                case(7):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishEmigrantViaKristianiaRecords()->create($request->all());
                    break;

                case(8):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishImmigrationStatisticsRecords()->create($request->all());
                    break;

                case(9):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishEmigrationStatisticsRecord()->create($request->all());
                    break;

                case(10):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->LarssonEmigrantPopularRecords()->create($request->all());
                    break;

                case(11):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->BrodernaLarssonArchiveRecords()->create($request->all());
                    break;

                case(12):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->JohnEricssonsArchiveRecords()->create($request->all());
                    break;


                case(13):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->NorwegianChurchImmigrantRecords()->create($request->all());
                    break;

                case(14):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->MormonShipPassengerRecords()->create($request->all());
                    break;
                case(15):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishAmericanMemberRecords()->create($request->all());
                    break;

                case(16):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedeInAlaskaRecords()->create($request->all());
                    break;

                case(17):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->VarmlandskaNewspaperNoticeRecords()->create($request->all());
                    break;


                case(18):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->DalslanningarBornInAmericaRecord()->create($request->all());
                    break;

                case(20):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->NorwayEmigrantRecords()->create($request->all());
                    break;

                case(21):
                    $request->merge([
                        'user_id' => auth()->user()->id
                    ]);
                    $archive->IcelandEmigrationRecords()->create($request->all());
                    break;

                default:
                    abort(403);
            }

            return redirect('/dashboard')->with('success', 'New record created!');

        }

        abort(403);

    }

    public function update(Organization $organization, Archive $archive, $record, Request $request)
    {
        $this->authorize('update', $archive);

        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required'
        ]);

        if($validated) {
            switch ($archive->id) {
                case(1):
                    $model = DenmarkEmigration::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(2):
//                    add last_name1 in validation for this to work
                    $model = SwedishAmericanChurchArchiveRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(3):
//                    update given and surname to first and last name
                    $model = NewYorkPassengerRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(4):

                    $model = SwedishPortPassengerListRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(5):
                    $model = SwedishChurchEmigrationRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(6):
                    $model = SwedishChurchImmigrantRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(7):
                    $model = SwedishEmigrantViaKristianiaRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(8):
                    $model = SwedishImmigrationStatisticsRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(9):
                    $model = SwedishEmigrationStatisticsRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(10):
                    $model = LarssonEmigrantPopularRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(11):
                    $model = BrodernaLarssonArchiveRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(12):
                    $model = JohnEricssonsArchiveRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(13):
                    $model = NorwegianChurchImmigrantRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(14):
                    $model = MormonShipPassengerRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(15):
                    $model = SwedishAmericanMemberRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(16):
                    $model = SwedeInAlaskaRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(17):
                    $model = VarmlandskaNewspaperNoticeRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(18):
                    $model = DalslanningarBornInAmericaRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(20):
                    $model = NorwayEmigrationRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(21):
                    $model = IcelandEmigrationRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                default:
                    abort(403);
            }

            return redirect('/dashboard')->with('success', 'The record was updated!');

        }

        abort(403);

    }

}
