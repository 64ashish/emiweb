<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use App\Models\BevaringensLevnadsbeskrivningarRecord;
use App\Models\BrodernaLarssonArchiveRecord;
use App\Models\DalslanningarBornInAmericaRecord;
use App\Models\DenmarkEmigration;
use App\Models\IcelandEmigrationRecord;
use App\Models\JohnEricssonsArchiveRecord;
use App\Models\LarssonEmigrantPopularRecord;
use App\Models\MormonShipPassengerRecord;
use App\Models\NewYorkPassengerRecord;
use App\Models\NorthenPacificRailwayCompanyRecord;
use App\Models\NorwayEmigrationRecord;
use App\Models\NorwegianChurchImmigrantRecord;
use App\Models\RsPersonalHistoryRecord;
use App\Models\SwedeInAlaskaRecord;
use App\Models\SwedishAmericanChurchArchiveRecord;
use App\Models\SwedishAmericanJubileeRecord;
use App\Models\SwedishAmericanMemberRecord;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishChurchImmigrantRecord;
use App\Models\SwedishEmigrantViaKristianiaRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
use App\Models\SwedishImmigrationStatisticsRecord;
use App\Models\SwedishPortPassengerListRecord;
use App\Models\VarmlandskaNewspaperNoticeRecord;
use App\Traits\UniversalQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Engines\MeiliSearchEngine;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;


class SearchController extends Controller
{
    use UniversalQuery;
    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }
    //
    public function index($archive)
    {
        switch($archive) {
            case(1):
//                $records = DenmarkEmigration::with('archive')->paginate(100);
//                $filterAttributes = $this->meilisearch->index('denmark_emigrations')->getFilterableAttributes();
                $model = new DenmarkEmigration();
                $viewfile = 'dashboard.denmarkemigration.records';
                break;

            case(2):
//                $records = SwedishAmericanChurchArchiveRecord::with('archive')->paginate(100);
//                $filterAttributes = $this->meilisearch->index('swedish_american_church_archive_records')->getFilterableAttributes();
                $model = new SwedishAmericanChurchArchiveRecord();
                $viewfile = 'dashboard.SwedishAmericanChurchArchiveRecord.records';
                break;

            case(3):
//                $records = NewYorkPassengerRecord::with('archive')->paginate(100);
//                $filterAttributes = $this->meilisearch->index('new_york_passenger_records')->getFilterableAttributes();
                $model = new NewYorkPassengerRecord();
                $viewfile = 'dashboard.NewYorkPassengerRecord.records';
                break;

            case(4):
//                $records = SwedishPortPassengerListRecord::with('archive')->paginate(100);
//                $filterAttributes = $this->meilisearch->index('swedish_port_passenger_list_records')->getFilterableAttributes();
                $model = new SwedishPortPassengerListRecord();
                $viewfile = 'dashboard.SwedishPortPassengerListRecord.records';
                break;

            case(5):
//                $records = SwedishChurchEmigrationRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_church_emigration_records')->getFilterableAttributes();
                $model = new SwedishChurchEmigrationRecord();
                $viewfile = 'dashboard.swedishchurchemigrationrecord.records';
                break;

            case(6):
//                $records = SwedishChurchImmigrantRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_church_immigrant_records')->getFilterableAttributes();
                $model = new SwedishChurchImmigrantRecord();
                $viewfile = 'dashboard.SwedishChurchImmigrantRecord.records';
                break;

            case(7):
//                $records = SwedishEmigrantViaKristianiaRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_emigrant_via_kristiania_records')->getFilterableAttributes();
                $model = new SwedishEmigrantViaKristianiaRecord();
                $viewfile = 'dashboard.SwedishEmigrantViaKristianiaRecord.records';
                break;

            case(8):
//                $records = SwedishImmigrationStatisticsRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_immigration_statistics_records')->getFilterableAttributes();
                $model = new SwedishImmigrationStatisticsRecord();
                $viewfile = 'dashboard.SwedishImmigrationStatisticsRecord.records';
                break;

            case(9):
//                $records = SwedishEmigrationStatisticsRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_emigration_statistics_records')->getFilterableAttributes();
                $model = new SwedishEmigrationStatisticsRecord();
                $viewfile = 'dashboard.scbe.records';
                break;

            case(10):
//                $records = LarssonEmigrantPopularRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('larsson_emigrant_popular_records')->getFilterableAttributes();
                $model = new LarssonEmigrantPopularRecord();
                $viewfile = 'dashboard.LarssonEmigrantPopularRecord.records';
                break;

            case(11):
//                $records = BrodernaLarssonArchiveRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('broderna_larsson_archive_records')->getFilterableAttributes();
                $model = new BrodernaLarssonArchiveRecord();
                $viewfile = 'dashboard.larsson.records';
                break;

            case(12):
//                $records = JohnEricssonsArchiveRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('john_ericssons_archive_records')->getFilterableAttributes();
                $model = new JohnEricssonsArchiveRecord();
                $viewfile = 'dashboard.JohnEricssonsArchiveRecord.records';
                break;

            case(13):
//                $records = NorwegianChurchImmigrantRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('norwegian_church_immigrant_records')->getFilterableAttributes();
                $model = new NorwegianChurchImmigrantRecord();
                $viewfile = 'dashboard.NorwegianChurchImmigrantRecord.records';
                break;

            case(14):
//                $records = MormonShipPassengerRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('mormon_ship_passenger_records')->getFilterableAttributes();
                $model = new MormonShipPassengerRecord();
                $viewfile = 'dashboard.MormonShipPassengerRecord.records';
                break;

            case(15):
//                $records = SwedishAmericanMemberRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swedish_american_member_records')->getFilterableAttributes();
                $model = new SwedishAmericanMemberRecord();
                $viewfile = 'dashboard.SwedishAmericanMemberRecord.records';
                break;

            case(16):
//                $records = SwedeInAlaskaRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('swede_in_alaska_records')->getFilterableAttributes();
                $model = new SwedeInAlaskaRecord();
                $viewfile = 'dashboard.SwedeInAlaskaRecord.records';
                break;

            case(17):
//                $records = VarmlandskaNewspaperNoticeRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('varmlandska_newspaper_notice_records')->getFilterableAttributes();
                $model = new VarmlandskaNewspaperNoticeRecord();
                $viewfile = 'dashboard.VarmlandskaNewspaperNoticeRecord.records';
                break;

            case(18):
//                $records = DalslanningarBornInAmericaRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('dalslanningar_born_in_america_records')->getFilterableAttributes();
                $model = new DalslanningarBornInAmericaRecord();
                $viewfile = 'dashboard.dbiar.records';
                break;

            case(20):
//                $records = NorwayEmigrationRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('norway_emigration_records')->getFilterableAttributes();
                $model = new NorwayEmigrationRecord();
                $viewfile = 'dashboard.norwayemigrationrecord.records';
                break;

            case(21):
//                $records = IcelandEmigrationRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('iceland_emigration_records')->getFilterableAttributes();
                $model = new IcelandEmigrationRecord();
                $viewfile = 'dashboard.IcelandEmmigrationRecord.records';
                break;

            case(22):
//                $records = IcelandEmigrationRecord::with('archive')->paginate(500);
//                $filterAttributes = $this->meilisearch->index('iceland_emigration_records')->getFilterableAttributes();
                $model = new BevaringensLevnadsbeskrivningarRecord();
                $viewfile = 'dashboard.IcelandEmmigrationRecord.records';
                break;

            case(23):
                $model = new SwedishAmericanJubileeRecord();
                $viewfile = 'dashboard.SwedishAmericanJubileeRecord.records';
                break;

            case(24):
                return "in progress";
//                $model = new SwedishAmericanJubileeRecord();
//                $viewfile = 'dashboard.SwedishAmericanJubileeRecord.records';
                break;

            case(25):
                $model = new NorthenPacificRailwayCompanyRecord();
                $viewfile = 'dashboard.NorthPacificRailwayCo.index';
                break;

            case(26):
                $model = new RsPersonalHistoryRecord();
                $viewfile = 'dashboard.rsphistory.records';
                break;
            default:
                abort(403);
        }

        $filterAttributes = collect($model->defaultSearchFields());

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $archive = Archive::findOrFail($archive);




        return view($viewfile, compact('filterAttributes', 'advancedFields','archive'));



    }
    public function search( Request  $request)
    {
        $inputFields = Arr::whereNotNull($request->except('_token'));
////        return $inputFields;
        $keywords = $request->except('_token');

////        run this for test only
////        $records = collect([
////            'Svenskamerikanska kyrkoarkivet'=> $this->QuerySwedishAmericanChurchArchiveRecord($inputFields)->count()
////        ]);
////
////        run this for production

        if(auth()->user()->hasRole(['regular user'])){
            $records = collect([
                'Den danska emigrantdatabasen'=> $this->QueryDenmarkEmigration($inputFields)
            ]);
        }
        else{
            $records = collect([
                'Emigranter registrerade i svenska kyrkböcker'=> $this->QuerySwedishChurchEmigrationRecord($inputFields),
                'Immigranter registrerade i svenska kyrkböcker'=> $this->QuerySwedishChurchImmigrantRecord($inputFields),
                'SCB Immigranter'=> $this->QuerySwedishImmigrationStatisticsRecord($inputFields),
                'SCB Emigranter'=> $this->QuerySwedishEmigrationStatisticsRecord($inputFields),
                'Immigranter i norska kyrkböcker'=> $this->QueryNorwegianChurchImmigrantRecord($inputFields),
                'Emigranter i norska kyrkböcker'=> $this->QueryNorwayEmigrationRecord($inputFields),
                'Den åländska emigrantdatabasen'=> $this->QueryIcelandEmigrationRecord($inputFields),
                'Den danska emigrantdatabasen'=> $this->QueryDenmarkEmigration($inputFields), //fix for dob
                'New Yorks passagerarlistor'=> $this->QueryNewYorkPassengerRecord($inputFields),
                'Passagerarlistor för svenska hamnar'=> $this->QuerySwedishPortPassengerListRecord($inputFields), //gives 500 error
                'Svenskar över Kristiania'=> $this->QuerySwedishEmigrantViaKristianiaRecord($inputFields),
                'Bröderna Larssons arkiv'=> $this->QueryBrodernaLarssonArchiveRecord($inputFields),//fix for dob
                'Mormonska passagerarlistor'=> $this->QueryMormonShipPassengerRecord($inputFields), //fix for dob
                'Svenskamerikanska kyrkoarkivet'=> $this->QuerySwedishAmericanChurchArchiveRecord($inputFields),
                'Svenskamerikanska föreningsmedlemmar'=> $this->QuerySwedishAmericanMemberRecord($inputFields),
                'Svenskar i Alaska'=> $this->QuerySwedeInAlaskaRecord($inputFields),
                'Dalslänningar födda i Amerika'=> $this->QueryDalslanningarBornInAmericaRecord($inputFields),
                'Bröderna Larssons arkiv (Index från Emigranten populär)'=> $this->QueryLarssonEmigrantPopularRecord($inputFields), //fix for dob
                'Tidningsnotiser från Värmländska tidningar'=> $this->QueryVarmlandskaNewspaperNoticeRecord($inputFields),
                'John Ericssons samling'=> $this->QueryJohnEricssonsArchiveRecord($inputFields), //fix for dob
                'Svenskamerikanska jubileumsskrifter'=> $this->QuerySwedishAmericanJubileeRecord($inputFields)
            ]);
        }
        return view('home.results', compact('records', 'keywords'));

    }


    public function show($arch, $id){
        $archive = Archive::find($arch);

////        return Archive::find($arch)->first();

        $this->authorize('view', $archive);
////        if authorized, do the thing

        switch($arch) {
            case(1):
                $detail = DenmarkEmigration::with('user.organization')->findOrFail($id);
                $model = new DenmarkEmigration();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(2):
                $detail = SwedishAmericanChurchArchiveRecord::with('user.organization')->findOrFail($id);
                $model = new SwedishAmericanChurchArchiveRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(3):
                $detail = NewYorkPassengerRecord::with('user.organization')->findOrFail($id);
                $model = new NewYorkPassengerRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(4):
                $detail = SwedishPortPassengerListRecord::with('user.organization')->findOrFail($id);
                $model = new SwedishPortPassengerListRecord();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $detail = SwedishChurchEmigrationRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = SwedishChurchEmigrationRecord::where('main_act', $detail->main_act)
                    ->whereNot('id', $detail->id)
                    ->where('from_parish', $detail->from_parish)
                    ->where('record_date', $detail->record_date)
                    ->get();
////                return $detail->relatives->count();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(6):
////                fix all date values for this table
                $model = new SwedishChurchImmigrantRecord();
                $detail = SwedishChurchImmigrantRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = SwedishChurchImmigrantRecord::where('main_act', $detail->main_act)
                    ->whereNot('id', $detail->id)
                    ->where('to_parish', $detail->to_parish)
                    ->where('to_date', $detail->to_date)
                    ->where('to_county', $detail->to_county)
                    ->get();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(7):
                $model = new SwedishEmigrantViaKristianiaRecord();
                $detail = SwedishEmigrantViaKristianiaRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(8):
                $model = new SwedishImmigrationStatisticsRecord();
                $detail = SwedishImmigrationStatisticsRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;


            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $detail = SwedishEmigrationStatisticsRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(10):
                $model = new LarssonEmigrantPopularRecord();
                $detail = LarssonEmigrantPopularRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $detail = BrodernaLarssonArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $detail = JohnEricssonsArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(13):
                $model = new NorwegianChurchImmigrantRecord();
                $detail = NorwegianChurchImmigrantRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = NorwegianChurchImmigrantRecord::whereNot('id', $detail->id)
                    ->where('family_nr', $detail->family_nr)
                    ->where('source_area', $detail->source_area)
                    ->where('to_date', $detail->to_date)
                    ->where('to_fylke', $detail->to_fylke)
                    ->get();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(14):
                $model = new MormonShipPassengerRecord();
                $detail = MormonShipPassengerRecord::with('user.organization')->findOrFail($id);
////                return $detail;
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(15):
                $model = new SwedishAmericanMemberRecord();
                $detail = SwedishAmericanMemberRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(16):
                $model = new SwedeInAlaskaRecord();
                $detail = SwedeInAlaskaRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(17):
                $model = new VarmlandskaNewspaperNoticeRecord();
                $detail = VarmlandskaNewspaperNoticeRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(18):

                $model = new DalslanningarBornInAmericaRecord();
                $detail = DalslanningarBornInAmericaRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(20):

                $model = new NorwayEmigrationRecord();
                $detail = NorwayEmigrationRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = NorwegianChurchImmigrantRecord::whereNot('id', $detail->id)
                    ->where('family_nr', $detail->family_nr)
                    ->where('source_area', $detail->source_area)
                    ->where('from_date', $detail->record_date)
                    ->where('from_fylke', $detail->from_fylke)
                    ->get();
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(21):

                $model = new IcelandEmigrationRecord();
                $detail = IcelandEmigrationRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(23):

                $model = new SwedishAmericanJubileeRecord();
                $detail = SwedishAmericanJubileeRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id','emi_web_lan','emi_web_forsamling','emi_web_emigration_year','emi_web_akt_nr',
                        'date_created','file_format','resolution','secrecy'])
                    ->flatten();
                break;


            default:
                abort(403);
        }

        $relatives = $detail->archive->relatives->where('record_id', $id);
        $images = $detail->archive->ImagesInArchive->where('record_id', $id);
        $archive_details = Archive::find($arch);

////        return $relatives->isEmpty();

////        return $detail;

        return view('home.showrecord', compact('detail', 'fields', 'relatives', 'images', 'archive_details'));

    }


}
