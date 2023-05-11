<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\BevaringensLevnadsbeskrivningarRecord;
use App\Models\BrodernaLarssonArchiveDocument;
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
use App\Models\ObituariesSweUsaNewspapersRecord;
use App\Models\Organization;
use App\Models\RsPersonalHistoryRecord;
use App\Models\SwedeInAlaskaRecord;
use App\Models\SwedishAmericanBookRecord;
use App\Models\SwedishAmericanChurchArchiveRecord;
use App\Models\SwedishAmericanJubileeRecord;
use App\Models\SwedishAmericanMemberRecord;
use App\Models\SwedishChurchEmigrationRecord;
use App\Models\SwedishChurchImmigrantRecord;
use App\Models\SwedishEmigrantViaKristianiaRecord;
use App\Models\SwedishEmigrationStatisticsRecord;
use App\Models\SwedishImmigrationStatisticsRecord;
use App\Models\SwedishPortPassengerListRecord;
use App\Models\SwedishUsaCentersEmiPhotoRecord;
use App\Models\SwensonCenterPhotosamlingRecord;
use App\Models\User;
use App\Models\VarmlandskaNewspaperNoticeRecord;
use App\Services\FindArchiveService;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class OrganizationArchiveController extends Controller
{
    //
    use SearchOrFilter;

    public function index()
    {
        return "get all archive";
    }
    public function ShowRecords(Organization $organization, Archive $archive, FindArchiveService $archiveService){

        $this->authorize('viewAny', $archive);

//        switch($archive->id) {
//            case(1):
////                $records = DenmarkEmigration::with('archive')->paginate(100);
////                $filterAttributes = $this->meilisearch->index('denmark_emigrations')->getFilterableAttributes();
//                $model = new DenmarkEmigration();
//                $viewfile = 'dashboard.denmarkemigration.records';
//                break;
//
//            case(2):
////                $records = SwedishAmericanChurchArchiveRecord::with('archive')->paginate(100);
////                $filterAttributes = $this->meilisearch->index('swedish_american_church_archive_records')->getFilterableAttributes();
//                $model = new SwedishAmericanChurchArchiveRecord();
//                $viewfile = 'dashboard.SwedishAmericanChurchArchiveRecord.records';
//                break;
//
//            case(3):
////                $records = NewYorkPassengerRecord::with('archive')->paginate(100);
////                $filterAttributes = $this->meilisearch->index('new_york_passenger_records')->getFilterableAttributes();
//                $model = new NewYorkPassengerRecord();
//                $viewfile = 'dashboard.NewYorkPassengerRecord.records';
//                break;
//
//            case(4):
////                $records = SwedishPortPassengerListRecord::with('archive')->paginate(100);
////                $filterAttributes = $this->meilisearch->index('swedish_port_passenger_list_records')->getFilterableAttributes();
//                $model = new SwedishPortPassengerListRecord();
//                $viewfile = 'dashboard.SwedishPortPassengerListRecord.records';
//                break;
//
//            case(5):
////                $records = SwedishChurchEmigrationRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_church_emigration_records')->getFilterableAttributes();
//                $model = new SwedishChurchEmigrationRecord();
//                $viewfile = 'dashboard.swedishchurchemigrationrecord.records';
//                break;
//
//            case(6):
////                $records = SwedishChurchImmigrantRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_church_immigrant_records')->getFilterableAttributes();
//                $model = new SwedishChurchImmigrantRecord();
//                $viewfile = 'dashboard.SwedishChurchImmigrantRecord.records';
//                break;
//
//            case(7):
////                $records = SwedishEmigrantViaKristianiaRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_emigrant_via_kristiania_records')->getFilterableAttributes();
//                $model = new SwedishEmigrantViaKristianiaRecord();
//                $viewfile = 'dashboard.SwedishEmigrantViaKristianiaRecord.records';
//                break;
//
//            case(8):
////                $records = SwedishImmigrationStatisticsRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_immigration_statistics_records')->getFilterableAttributes();
//                $model = new SwedishImmigrationStatisticsRecord();
//                $viewfile = 'dashboard.SwedishImmigrationStatisticsRecord.records';
//                break;
//
//            case(9):
////                $records = SwedishEmigrationStatisticsRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_emigration_statistics_records')->getFilterableAttributes();
//                $model = new SwedishEmigrationStatisticsRecord();
//                $viewfile = 'dashboard.scbe.records';
//                break;
//
//            case(10):
////                $records = LarssonEmigrantPopularRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('larsson_emigrant_popular_records')->getFilterableAttributes();
//                $model = new LarssonEmigrantPopularRecord();
//                $viewfile = 'dashboard.LarssonEmigrantPopularRecord.records';
//                break;
//
//            case(11):
////                $records = BrodernaLarssonArchiveRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('broderna_larsson_archive_records')->getFilterableAttributes();
//                $model = new BrodernaLarssonArchiveRecord();
//                $viewfile = 'dashboard.larsson.records';
//                break;
//
//            case(12):
////                $records = JohnEricssonsArchiveRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('john_ericssons_archive_records')->getFilterableAttributes();
//                $model = new JohnEricssonsArchiveRecord();
//                $viewfile = 'dashboard.JohnEricssonsArchiveRecord.records';
//                break;
//
//            case(13):
////                $records = NorwegianChurchImmigrantRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('norwegian_church_immigrant_records')->getFilterableAttributes();
//                $model = new NorwegianChurchImmigrantRecord();
//                $viewfile = 'dashboard.NorwegianChurchImmigrantRecord.records';
//                break;
//
//            case(14):
////                $records = MormonShipPassengerRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('mormon_ship_passenger_records')->getFilterableAttributes();
//                $model = new MormonShipPassengerRecord();
//                $viewfile = 'dashboard.MormonShipPassengerRecord.records';
//                break;
//
//            case(15):
////                $records = SwedishAmericanMemberRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swedish_american_member_records')->getFilterableAttributes();
//                $model = new SwedishAmericanMemberRecord();
//                $viewfile = 'dashboard.SwedishAmericanMemberRecord.records';
//                break;
//
//            case(16):
////                $records = SwedeInAlaskaRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('swede_in_alaska_records')->getFilterableAttributes();
//                $model = new SwedeInAlaskaRecord();
//                $viewfile = 'dashboard.SwedeInAlaskaRecord.records';
//                break;
//
//            case(17):
////                $records = VarmlandskaNewspaperNoticeRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('varmlandska_newspaper_notice_records')->getFilterableAttributes();
//                $model = new VarmlandskaNewspaperNoticeRecord();
//                $viewfile = 'dashboard.VarmlandskaNewspaperNoticeRecord.records';
//                break;
//
//            case(18):
////                $records = DalslanningarBornInAmericaRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('dalslanningar_born_in_america_records')->getFilterableAttributes();
//                $model = new DalslanningarBornInAmericaRecord();
//                $viewfile = 'dashboard.dbiar.records';
//                break;
//
//            case(20):
////                $records = NorwayEmigrationRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('norway_emigration_records')->getFilterableAttributes();
//                $model = new NorwayEmigrationRecord();
//                $viewfile = 'dashboard.norwayemigrationrecord.records';
//                break;
//
//            case(21):
////                $records = IcelandEmigrationRecord::with('archive')->paginate(500);
////                $filterAttributes = $this->meilisearch->index('iceland_emigration_records')->getFilterableAttributes();
//                $model = new IcelandEmigrationRecord();
//                $viewfile = 'dashboard.IcelandEmmigrationRecord.records';
//
//                break;
//
//            case(22):
//                $model = new BevaringensLevnadsbeskrivningarRecord();
//                $viewfile = 'dashboard.IcelandEmmigrationRecord.records';
//                break;
//
//            case(23):
//                $model = new SwedishAmericanJubileeRecord();
//                $viewfile = 'dashboard.SwedishAmericanJubileeRecord.records';
//                break;
//
//            case(24):
//
//                $model = new SwensonCenterPhotosamlingRecord();
//                $viewfile = 'dashboard.swenphotocenter.records';
//                break;
//
//            case(25):
//                $model = new NorthenPacificRailwayCompanyRecord();
//                $viewfile = 'dashboard.NorthPacificRailwayCo.index';
//                break;
//
//            case(26):
//                $model = new RsPersonalHistoryRecord();
//                $viewfile = 'dashboard.rsphistory.photos';
//                break;
//
//            case(27):
//                $model = new SwedishUsaCentersEmiPhotoRecord();
//                $viewfile = 'dashboard.suscepc.records';
//                break;
//
//            case(28):
//                $model = new SwedishAmericanBookRecord();
//                $viewfile = 'dashboard.sabr.records';
//                break;
//
//            default:
//                abort(403);
//        }

//
        $model = $archiveService->getSelectedArchive($archive->id)['model'];
        $viewfile = $archiveService->getSelectedArchive($archive->id)['viewfile'];
        $genders = $archiveService->getSelectedArchive($archive->id)['genders'];


        $filterAttributes = collect($model->defaultSearchFields());
        $enableQueryMatch =$model->enableQueryMatch();
        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces();

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();


//        return $filterAttributes;

        if(method_exists($model, 'searchFields'))
        {
            $advancedFields = $model->searchFields();
        }else{
            $advancedFields = $fields->diff($filterAttributes)->flatten();
        }

        $archive_name = $archive;


        return view($viewfile, compact('filterAttributes', 'advancedFields','organization', 'archive', 'enableQueryMatch', 'provinces', 'archive_name'));

    }

    public function view(Organization $organization, Archive $archive, $id){


//        check if user has permission
        $this->authorize('view', $archive);

//        if authorized, do the thing

        switch($archive->id) {
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
                $detail = SwedishChurchEmigrationRecord::with(['user.organization','photo'])->findOrFail($id);
                $detail->relatives = SwedishChurchEmigrationRecord::where('main_act', $detail->main_act)
                    ->whereNot('id', $detail->id)
                    ->where('from_parish', $detail->from_parish)
                    ->where('record_date', $detail->record_date)
                    ->get();
                $detail->links = [
                    'Immigrants in Swedish church records' => SwedishChurchImmigrantRecord::where('first_name', $detail->first_name)
                        ->where('last_name', $detail->last_name)
                        ->where('birth_date', $detail->dob)
                        ->where('sex', $detail->gender)
                        ->where('birth_parish', $detail->birth_parish)
                        ->where('birth_county', $detail->from_province)
                        ->get('id')->first()
                ];
                $media = !empty($detail->document)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos".$detail->document->file_name:false;
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
                if(!empty($detail->source_code))
                {
                    $text_code = explode(':', $detail->source_code);
                    if(strlen($text_code[2])<4)
                    {
                        $text_code[2] = substr_replace($text_code[2], "0", 1, 0);
                    }



                    $media_file = BrodernaLarssonArchiveDocument::where('file_name', 'like', '%'. $text_code[1]. '_' .$text_code[2] .'%')->first();
                    $media = "";
                    if($media_file)
                    {
                        $media ="https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/11/documents/Larsson/".$media_file->year."/".$media_file->file_name;
                    }


                }
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $detail = BrodernaLarssonArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                $media ="https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/11/documents/Larsson/".explode('-', $detail->letter_date)[0]."/".$detail->file_name.".pdf";
                break;

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $detail = JohnEricssonsArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                $media = "https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/12/documents/".$detail->file_name;

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
                $detail = MormonShipPassengerRecord::select('*', DB::raw("CONCAT('departure_year','/','departure_month','/','departure_day') AS departure_date"))
                    ->with('user.organization')
                    ->findOrFail($id);
////                return $detail;
                $fields = collect($model->getFillable())->concat(['departure_date'])
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id','departure_year','departure_month','departure_day'])
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
                $media = !empty($detail->file_name)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/Archive/Sverige_Amerika_Centret".substr($detail->file_name,39):false;
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
                    ->where('to_date', $detail->record_date)
                    ->where('to_fylke', $detail->from_fylke)
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
                $media = !empty($detail->file_name)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/27/Archive/Sverige_Amerika_Centret/BLB/".$detail->file_name:false;
                break;

            case(23):

                $model = new SwedishAmericanJubileeRecord();
                $detail = SwedishAmericanJubileeRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id','emi_web_lan','emi_web_forsamling','emi_web_emigration_year','emi_web_akt_nr',
                        'date_created','file_format','resolution','secrecy'])
                    ->flatten();
                break;

            case(24):

                $model = new SwensonCenterPhotosamlingRecord();
                $detail = SwensonCenterPhotosamlingRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                $media = !empty($detail->file_name)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/24/Archive/Swenson_Center/".substr($detail->file_name, '0','3')."/".str_replace(" ", "_",substr($detail->file_name,3)):false;

                break;

            case(26):

                $model = new RsPersonalHistoryRecord();
                $detail = RsPersonalHistoryRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(27):

                $model = new SwedishUsaCentersEmiPhotoRecord();
                $detail = SwedishUsaCentersEmiPhotoRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(28):
                $model = new SwedishAmericanBookRecord();
                $detail = SwedishAmericanBookRecord::with('user.organization','SwensonBookData')->findOrFail($id);
//                return $detail;
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(29):
                $model = new ObituariesSweUsaNewspapersRecord();
                $detail = ObituariesSweUsaNewspapersRecord::with('user.organization')->findOrFail($id);
//                return $detail;
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
//                bucketemiweb/archives/5/photos/Archive/Svenska_Emigrantinstitutet/Sandebudet/._Carl_Henry_Carlsten.jpg
                $media = !empty($detail->file_name)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/".$detail->file_name:false;
                break;

            default:
                abort(403);
        }

        $relatives = $detail->archive->relatives->where('record_id', $id);
//        $archive_details = Archive::find($archive);
        $media = isset($media)?$media:false;


        return view('dashboard.show', compact('detail', 'fields', 'archive','relatives', 'media'));


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

            return redirect('organization/'.$organization->id.'/archives/'.$archive->id.'/records/'.$record)->with('success', 'The record was updated!');

        }

        abort(403);

    }

}
