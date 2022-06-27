<?php

namespace App\Http\Controllers;

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
use App\Models\SwedeInAlaskaRecord;
use App\Models\SwedishAmericanChurchArchiveRecord;
use App\Models\SwedishAmericanMemberRecord;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishChurchImmigrantRecord;
use App\Models\SwedishEmigrantViaKristianiaRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
use App\Models\SwedishImmigrationStatisticsRecord;
use App\Models\SwedishPortPassengerListRecord;
use App\Models\VarmlandskaNewspaperNoticeRecord;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index($archive)
    {


        switch($archive) {
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


        return view($viewfile, compact('records'));



    }
    public function search( Request  $request)
    {
        $keywords = $request->search;
        $q1 = DenmarkEmigration::search($keywords)->get()->load('archive');


        if(auth()->user()->hasRole('regular user'))
        {
            $records = $q1;
        }
        else{
            $q2 = SwedishChurchEmigrationRecord::search($keywords)->get()->load('archive');
            $q3 = DalslanningarBornInAmericaRecord::search($keywords)->get()->load('archive');
            $q4 = SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');
            $q5 = BrodernaLarssonArchiveRecord::search($keywords)->get()->load('archive');

            $q6 = SwedishAmericanChurchArchiveRecord::search($keywords)->get()->load('archive');
            $q7 = NewYorkPassengerRecord::search($keywords)->get()->load('archive');
            $q8 = SwedishPortPassengerListRecord::search($keywords)->get()->load('archive');
            $q9 = SwedishChurchImmigrantRecord::search($keywords)->get()->load('archive');
            $q10 = SwedishEmigrantViaKristianiaRecord::search($keywords)->get()->load('archive');
            $q11 = SwedishImmigrationStatisticsRecord::search($keywords)->get()->load('archive');
            $q12 = LarssonEmigrantPopularRecord::search($keywords)->get()->load('archive');
            $q13 = JohnEricssonsArchiveRecord::search($keywords)->get()->load('archive');
            $q14 = NorwegianChurchImmigrantRecord::search($keywords)->get()->load('archive');
            $q15 = MormonShipPassengerRecord::search($keywords)->get()->load('archive');
            $q16 = SwedishAmericanMemberRecord::search($keywords)->get()->load('archive');
            $q17 = SwedeInAlaskaRecord::search($keywords)->get()->load('archive');
            $q18 = VarmlandskaNewspaperNoticeRecord::search($keywords)->get()->load('archive');
            $q19 = NorwayEmigrationRecord::search($keywords)->get()->load('archive');
            $q20 = IcelandEmigrationRecord::search($keywords)->get()->load('archive');

            $records = collect([$q1, $q2, $q3, $q4, $q5, $q6, $q7, $q8, $q9, $q10, $q11, $q12, $q13, $q14, $q15, $q16, $q17, $q18, $q19, $q20 ])->flatten();
        }
//        return DenmarkEmigration::search($keywords)->get()->load('archive');


//        return SwedishEmigrationStatisticsRecord::search($keywords)->get()->load('archive');
//        return $records ;
        return view('home.results', compact('records', 'keywords'));

    }
    public function show($arch, $id){


        //        if authorized, do the thing

        switch($arch) {
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

        return view('home.showrecord', compact('detail', 'fields'));

    }


}
