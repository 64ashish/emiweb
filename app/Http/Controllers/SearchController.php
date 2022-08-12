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
use App\Traits\UniversalQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

            default:
                abort(403);
        }

        $filterAttributes = collect($model->defaultSearchFields());
        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();
        $advancedFields = $fields->diff($filterAttributes)->flatten();
        $archive = Archive::findOrFail($archive);

//        return $archi->name;

        return view($viewfile, compact('filterAttributes', 'advancedFields','archive'));



    }
    public function search( Request  $request)
    {
//        return $request->fullUrlIs(['full_name']);

        $inputFields = Arr::whereNotNull($request->except('_token'));
        $keywords = $request->except('_token');

        $records = collect([
            'Den danska emigrantdatabasen'=> $this->QueryDenmarkEmigration($inputFields)->count(),
            'Svenskamerikanska kyrkoarkivet'=> $this->QuerySwedishAmericanChurchArchiveRecord($inputFields)->count(),
            'New Yorks passagerarlistor'=> $this->QueryNewYorkPassengerRecord($inputFields)->count(),
            'Passagerarlistor för svenska hamnar'=> $this->QuerySwedishPortPassengerListRecord($inputFields)->count(),
            'Emigranter registrerade i svenska kyrkböcker'=> $this->QuerySwedishChurchEmigrationRecord($inputFields)->count(),
            'Immigranter registrerade i svenska kyrkböcker'=> $this->QuerySwedishChurchImmigrantRecord($inputFields)->count(),
            'Svenskar över Kristiania'=> $this->QuerySwedishEmigrantViaKristianiaRecord($inputFields)->count(),
            'SCB Immigranter'=> $this->QuerySwedishImmigrationStatisticsRecord($inputFields)->count(),
            'SCB Emigranter'=> $this->QuerySwedishEmigrationStatisticsRecord($inputFields)->count(),
            'Bröderna Larssons arkiv (Index från Emigranten populär)'=> $this->QueryLarssonEmigrantPopularRecord($inputFields)->count(),
            'Bröderna Larssons arkiv'=> $this->QueryBrodernaLarssonArchiveRecord($inputFields)->count(),
            'John Ericssons samling'=> $this->QueryJohnEricssonsArchiveRecord($inputFields)->count(),
            'Immigranter i norska kyrkböcker'=> $this->QueryNorwegianChurchImmigrantRecord($inputFields)->count(),
            'Mormonska passagerarlistor'=> $this->QueryMormonShipPassengerRecord($inputFields)->count(),
            'Svenskamerikanska föreningsmedlemmar'=> $this->QuerySwedishAmericanMemberRecord($inputFields)->count(),
            'Svenskar i Alaska'=> $this->QuerySwedeInAlaskaRecord($inputFields)->count(),
            'Tidningsnotiser från Värmländska tidningar'=> $this->QueryVarmlandskaNewspaperNoticeRecord($inputFields)->count(),
            'Dalslänningar födda i Amerika'=> $this->QueryDalslanningarBornInAmericaRecord($inputFields)->count(),
            'Emigranter i norska kyrkböcker'=> $this->QueryNorwayEmigrationRecord($inputFields)->count(),
            'Den åländska emigrantdatabasen'=> $this->QueryIcelandEmigrationRecord($inputFields)->count(),




            ]);

//        return $records['Den danska emigrantdatabasen'];

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

        $relatives = $detail->archive->relatives->where('record_id', $id);
        $images = $detail->archive->ImagesInArchive->where('record_id', $id);
        $archive_details = Archive::find($arch);

//        return $relatives->isEmpty();

        return view('home.showrecord', compact('detail', 'fields', 'relatives', 'images', 'archive_details'));

    }


}
