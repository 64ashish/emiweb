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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class OrganizationArchiveController extends Controller
{
    //
    use SearchOrFilter;

    public function index()
    {
        return "get all archive";
    }

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @param FindArchiveService $archiveService
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function ShowRecords(Organization $organization, Archive $archive, FindArchiveService $archiveService){

        $this->authorize('viewAny', $archive);

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

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
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
                $media = !empty($detail->document)?Storage::disk('s3')->temporaryUrl("archives/5/photos".$detail->document->file_name, now()->addMinutes(60)):false;
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
                        $media = Storage::disk('s3')->temporaryUrl("archives/11/documents/Larsson/".$media_file->year."/".$media_file->file_name, now()->addMinutes(60));
                    }


                }
                break;

            case(11):
                $model = new BrodernaLarssonArchiveRecord();
                $detail = BrodernaLarssonArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                $media = Storage::disk('s3')->temporaryUrl("archives/11/documents/Larsson/".explode('-', $detail->letter_date)[0]."/".$detail->file_name.".pdf", now()->addMinutes(60));
                break;

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $detail = JohnEricssonsArchiveRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                    // pre($detail); exit;
                $media = isset($detail->file_name) ? Storage::disk('s3')->temporaryUrl("archives/12/documents/".$detail->file_name, now()->addMinutes(60)) : '';

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
                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/5/photos/Archive/Sverige_Amerika_Centret".substr($detail->file_name,39), now()->addMinutes(60)):false;
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

            case(22):

                $model = new BevaringensLevnadsbeskrivningarRecord();
                $detail = BevaringensLevnadsbeskrivningarRecord::with('user.organization','activities','professions')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id', 'occupation_1', 'occupation_2', 'profession_3', 'profession_4'])
                    ->flatten();

//                return $detail;


                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/27/Archive/Sverige_Amerika_Centret/BLB/".$detail->file_name, now()->addMinutes(60)):false;


//                return $detail;
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
                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/24/Archive/Swenson_Center/".substr($detail->file_name, '0','3')."/".str_replace(" ", "_",substr($detail->file_name,3)), now()->addMinutes(60)):false;

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
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
//                bucketemiweb/archives/5/photos/Archive/Svenska_Emigrantinstitutet/Sandebudet/._Carl_Henry_Carlsten.jpg
                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/5/photos/".$detail->file_name, now()->addMinutes(60)):false;
                break;

            default:
                abort(403);
        }

        $relatives = $detail->archive->relatives->where('record_id', $id);
//        $archive_details = Archive::find($archive);
        $media = isset($media)?$media:false;


        return view('dashboard.show', compact('detail', 'fields', 'archive','relatives', 'media'));


    }

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(Organization $organization, Archive $archive)
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

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @param $record
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Organization $organization, Archive $archive, $record)
    {
        // pre($archive); exit;
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

            case(22):
                $model = new BevaringensLevnadsbeskrivningarRecord();
                $record = BevaringensLevnadsbeskrivningarRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(23):
                $model = new SwedishAmericanJubileeRecord();
                $record = SwedishAmericanJubileeRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(24):
                $model = new SwensonCenterPhotosamlingRecord();
                $record = SwensonCenterPhotosamlingRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(26):
                $model = new RsPersonalHistoryRecord();
                $record = RsPersonalHistoryRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(27):
                $model = new SwedishUsaCentersEmiPhotoRecord();
                $record = SwedishUsaCentersEmiPhotoRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(28):
                $model = new SwedishAmericanBookRecord();
                $record = SwedishAmericanBookRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(29):
                $model = new ObituariesSweUsaNewspapersRecord();
                $record = ObituariesSweUsaNewspapersRecord::findOrFail($record);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            default:
                abort(403);
        }

        return view('dashboard.update', compact('record',"organization", "archive", 'fields'));

    }

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     * @throws AuthorizationException
     */
    public function store(Organization $organization, Archive $archive, Request $request)
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
                // add last_name1 in validation for this to work
                case(2):
                    $request->merge([
                        'user_id' => auth()->user()->id,
                        'organization_id' => auth()->user()->organization_id
                    ]);
                    $archive->SwedishAmericanChurchArchiveRecords()->create($request->all());
                    break;

                case(3):
                // update given name and surname to first and last names
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

    /**
     * @param Organization $organization
     * @param Archive $archive
     * @param $record
     * @param Request $request
     * @return Application|RedirectResponse|Redirector|void
     * @throws AuthorizationException
     */
    public function update(Organization $organization, Archive $archive, $record, Request $request)
    {
        $this->authorize('update', $archive);

        $validated = true;
        if($archive->id != 23 && $archive->id != 24 && $archive->id != 27){
            $validated = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);
        }

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

                case(22):
                    $model = BevaringensLevnadsbeskrivningarRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(23):
                    $model = SwedishAmericanJubileeRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(24):
                    $model = SwensonCenterPhotosamlingRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(26):
                    $model = RsPersonalHistoryRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(27):
                    $model = SwedishUsaCentersEmiPhotoRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(28):
                    $model = SwedishAmericanBookRecord::findOrFail($record);
                    $model->update($request->except(['_token', '_method' ]));
                    break;

                case(29):
                    $model = ObituariesSweUsaNewspapersRecord::findOrFail($record);
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
