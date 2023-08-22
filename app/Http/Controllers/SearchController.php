<?php
//
namespace App\Http\Controllers;

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
use App\Models\RsPersonalHistoryRecord;
use App\Models\SpplrReference;
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
use App\Models\VarmlandskaNewspaperNoticeRecord;
use App\Services\FindArchiveService;
use App\Traits\SearchOrFilter;
use App\Traits\UniversalQuery;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Engines\MeiliSearchEngine;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;


class SearchController extends Controller
{
    use UniversalQuery, SearchOrFilter;

    //

    /**
     * @param $archive
     * @param FindArchiveService $archiveService
     * @return Application|Factory|View|never
     */
    public function index($archive, FindArchiveService $archiveService)
    {
        if($archive !=1 and auth()->user()->hasRole('regular user'))
        {
//            return "one";
            return abort(403, 'Unauthorized action.');
        }
        if($archive !=1 and auth()->user()->hasRole(['subscriber']) and (!is_null(auth()->user()->manual_expire) and !Carbon::parse(auth()->user()->manual_expire)->greaterThanOrEqualTo(Carbon::now())))
        {
//            return "two";
            return abort(403, 'Unauthorized action.');
        }
        $model = $archiveService->getSelectedArchive($archive)['model'];
        $viewfile = $archiveService->getSelectedArchive($archive)['viewfile'];
        $genders = $archiveService->getSelectedArchive($archive)['genders'];

        $filterAttributes = collect($model->defaultSearchFields());
        $enableQueryMatch =$model->enableQueryMatch();
        $ProvincesParishes = collect($this->ProvincesParishes());
        $provinces = $this->provinces();

        $fields = collect($model->getFillable())
            ->diff(['user_id', 'archive_id', 'organization_id','old_id','first_name', 'last_name'])
            ->flatten();

        if(method_exists($model, 'searchFields'))
        {
            $advancedFields = $model->searchFields();
        }else{
            $advancedFields = $fields->diff($filterAttributes)->flatten();
        }


        $archive = Archive::findOrFail($archive);
        $archive_name = $archive;

//        return $archive_name;
        return view($viewfile, compact('filterAttributes', 'advancedFields','archive', 'archive_name','enableQueryMatch', 'provinces','genders', 'ProvincesParishes'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function search(Request $request)
    {
        $inputFields = Arr::whereNotNull($request->except('_token'));
        $keywords = $request->except('_token');

        if(!is_null($request->qry_first_name))
        {

            $inputFields['qry_first_name'] = preg_replace('/\s+/', ' ', $request->qry_first_name);
            $keywords['qry_first_name'] = preg_replace('/\s+/', ' ', $request->qry_first_name);

        }

        if(!is_null($request->qry_last_name))
        {
            $inputFields['qry_last_name'] = preg_replace('/\s+/', ' ', $request->qry_last_name);
            $keywords['qry_last_name'] = preg_replace('/\s+/', ' ', $request->qry_last_name);
        }

//        $keywords = $request->except('_token');

//        return $inputFields;



        if(auth()->user()->hasRole(['regular user'])){
            $records = collect([
                'Den danska emigrantdatabasen'=> $this->QueryDenmarkEmigration($inputFields)
            ]);
        }
        else{
            $records = collect([
                'Emigrants in Swedish church records'=> $this->QuerySwedishChurchEmigrationRecord($inputFields),
                'Immigrants in Swedish church records'=> $this->QuerySwedishChurchImmigrantRecord($inputFields),
                'SCB immigrants'=> $this->QuerySwedishImmigrationStatisticsRecord($inputFields),
                'SCB emigrants'=> $this->QuerySwedishEmigrationStatisticsRecord($inputFields),
                'Immigrants in Norwegian church records'=> $this->QueryNorwegianChurchImmigrantRecord($inputFields),
                'Emigrants in Norwegian church records'=> $this->QueryNorwayEmigrationRecord($inputFields),
                'The Åland emigrant database'=> $this->QueryIcelandEmigrationRecord($inputFields),
                'The Danish emigrant database'=> $this->QueryDenmarkEmigration($inputFields), //fix for dob
                'New Yorks Passenger lists'=> $this->QueryNewYorkPassengerRecord($inputFields),
                'Passenger lists for Swedish ports'=> $this->QuerySwedishPortPassengerListRecord($inputFields), //gives 500 error
                'Swedes over Kristiania'=> $this->QuerySwedishEmigrantViaKristianiaRecord($inputFields),
                'The Larsson Brothers archive'=> $this->QueryBrodernaLarssonArchiveRecord($inputFields),//fix for dob
                'Mormon passenger list, Scandinavia'=> $this->QueryMormonShipPassengerRecord($inputFields), //fix for dob
                'Swedish American Church Archive (SAKA)'=> $this->QuerySwedishAmericanChurchArchiveRecord($inputFields),
                'Swedish American association members'=> $this->QuerySwedishAmericanMemberRecord($inputFields),
                'Swedes in Alaska'=> $this->QuerySwedeInAlaskaRecord($inputFields),
                'Life descriptions of the conscripts'=> $this->QueryBevaringensLevnadsbeskrivningar($inputFields),
                'Dalslänningar born in America'=> $this->QueryDalslanningarBornInAmericaRecord($inputFields),
                'The Larsson Brothers American agent archive'=> $this->QueryLarssonEmigrantPopularRecord($inputFields), //fix for dob
                'Newspaper notices from Värmland newspapers'=> $this->QueryVarmlandskaNewspaperNoticeRecord($inputFields),
                'The John Ericsson Archive'=> $this->QueryJohnEricssonsArchiveRecord($inputFields), //fix for dob
                'Swedish-American anniversary writings'=> $this->QuerySwedishAmericanJubileeRecord($inputFields),
                'Svenskamerikanskt bokindex' =>$this->QuerySwedishAmericanBookRecord($inputFields),
                'Obituaries from Swedish American newspapers' =>$this->QueryObituariesSweUsaNewspapersRecord($inputFields)
            ]);
        }



        dd($records);
//        return $keywords;
        return view('home.results', compact('records', 'keywords'));

    }

    /**
     * @param $arch
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function show($arch, $id ){
        $archive = Archive::find($arch);


////        return Archive::find($arch)->first();

        $this->authorize('view', $archive);
////        if authorized, do the thing

        switch($arch) {
            case(1):
                $detail = DenmarkEmigration::with('user.organization')->findOrFail($id);
                $model = new DenmarkEmigration();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(2):
                $detail = SwedishAmericanChurchArchiveRecord::with('user.organization')->findOrFail($id);
                $model = new SwedishAmericanChurchArchiveRecord();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(3):
                $detail = NewYorkPassengerRecord::with('user.organization')->findOrFail($id);
                $model = new NewYorkPassengerRecord();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(4):
                $detail = SwedishPortPassengerListRecord::with('user.organization')->findOrFail($id);
                if(!is_null($detail->source_reference))
                {
                    preg_match_all("/\d+/", $detail->source_reference, $matches);

//                    return $matches;
//
                      if(count($matches[0]) == 3)
                      {
                          $riksarkivet = SpplrReference::where('index_batch_reference',"SE/GLA/12703/E IX/".$matches[0][0])
//                              ->where('page_one',$matches[0][1])
//                              ->orWhere('page_two',$matches[0][1])
                              ->where(function ($query) use ($matches) {
                                  $query->where('page_one','=',$matches[0][1])
                                      ->orWhere('page_two','=',$matches[0][1]);
                              })
//                              ->first()->image_id;
                              ->first();

                          if(!is_null($riksarkivet))
                          {
                              $detail->riksarkivet = $riksarkivet->image_id;
                          }

                      }
                }

                $model = new SwedishPortPassengerListRecord();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(5):
                $model = new SwedishChurchEmigrationRecord();
                $detail = SwedishChurchEmigrationRecord::with(['user.organization','photo','document'])->findOrFail($id);
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

                $theFillables = collect($model->getFillable());

                $media = !empty($detail->document)?Storage::disk('s3')->temporaryUrl("archives/5/photos".$detail->document->file_name, now()->addMinutes(60)):false;


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

                $detail->links = [
                    'Emigrants in Swedish church records' => SwedishChurchEmigrationRecord::where('first_name', $detail->first_name)
                        ->where('last_name', $detail->last_name)
                        ->where('dob', $detail->birth_date)
                        ->where('gender', $detail->sex)
                        ->where('birth_parish', $detail->birth_parish)
                        ->where('from_province', $detail->birth_county)
                        ->get('id')->first()
                ];

                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(7):
                $model = new SwedishEmigrantViaKristianiaRecord();
                $detail = SwedishEmigrantViaKristianiaRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(8):
                $model = new SwedishImmigrationStatisticsRecord();
                $detail = SwedishImmigrationStatisticsRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(9):
                $model = new SwedishEmigrationStatisticsRecord();
                $detail = SwedishEmigrationStatisticsRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = SwedishEmigrationStatisticsRecord::where('family_number', $detail->family_number)
                    ->whereNot('id', $detail->id)
                    ->where('last_name', $detail->last_name)
                    ->where('destination', $detail->destination)
                    ->where('from_province', $detail->from_province)
                    ->get();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(10):
                $model = new LarssonEmigrantPopularRecord();
                $detail = LarssonEmigrantPopularRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
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
//                return explode('-', $detail->letter_date)[0];
                $media = Storage::disk('s3')->temporaryUrl("archives/11/documents/Larsson/".explode('-', $detail->letter_date)[0]."/".$detail->file_name.".pdf", now()->addMinutes(60));

                //dd($detail->file_name);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(12):
                $model = new JohnEricssonsArchiveRecord();
                $detail = JohnEricssonsArchiveRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                $media = Storage::disk('s3')->temporaryUrl("archives/12/documents/".$detail->file_name, now()->addMinutes(60));

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
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(14):
                $model = new MormonShipPassengerRecord();
                $detail = MormonShipPassengerRecord::select('*', DB::raw("CONCAT('departure_year','/','departure_month','/','departure_day') AS departure_date"))
                    ->with('user.organization')
                    ->findOrFail($id);
                $detail->relatives = MormonShipPassengerRecord::whereNot('id',$detail->id)
                    ->where('family_nr', $detail->family_nr)
                    ->where('dgsnr', $detail->dgsnr)
                    ->where('last_name', $detail->last_name)
                    ->where('libr_no', $detail->libr_no)
                    ->get();
//                return $detail;
                $theFillables = collect($model->getFillable())->concat(['departure_date'])
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id','departure_year','departure_month','departure_day'])
                    ->flatten();
                break;

            case(15):
                $model = new SwedishAmericanMemberRecord();
                $detail = SwedishAmericanMemberRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(16):
                $model = new SwedeInAlaskaRecord();
                $detail = SwedeInAlaskaRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(17):
                $model = new VarmlandskaNewspaperNoticeRecord();
                $detail = VarmlandskaNewspaperNoticeRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();

                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/5/photos/Archive/Sverige_Amerika_Centret".substr($detail->file_name,39), now()->addMinutes(60)):false;
                break;
//                https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/Archive/Sverige_Amerika_Centret/VTN/VTN-1-1-NWT19631212.jpg
//                https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/Archive/Sverige Amerika Centret/VTN/VTN-1-1-NWT19631212.jpg
//                https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/Archive/Sverige Amerika Centret/VTN/VTN-1-1-NWT19631212.jpg

            case(18):

                $model = new DalslanningarBornInAmericaRecord();
                $detail = DalslanningarBornInAmericaRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(20):

                $model = new NorwayEmigrationRecord();
                $detail = NorwayEmigrationRecord::with('user.organization')->findOrFail($id);
                $detail->relatives = NorwayEmigrationRecord::whereNot('id', $detail->id)
                    ->where('family_number', $detail->family_number)
                    ->where('source_area', $detail->source_area)
//                    ->where('registered_date', $detail->registered_date)
//                    ->where('to_fylke', $detail->from_fylke)
                    ->get();
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(21):

                $model = new IcelandEmigrationRecord();
                $detail = IcelandEmigrationRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;
            case(22):

                $model = new BevaringensLevnadsbeskrivningarRecord();
                $detail = BevaringensLevnadsbeskrivningarRecord::with('user.organization','activities','professions')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id', 'occupation_1', 'occupation_2', 'profession_3', 'profession_4'])
                    ->flatten();

//                return $detail;


                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/27/Archive/Sverige_Amerika_Centret/BLB/".$detail->file_name, now()->addMinutes(60)):false;


//                return $detail;
                break;
            case(23):

                $model = new SwedishAmericanJubileeRecord();
                $detail = SwedishAmericanJubileeRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id','emi_web_lan','emi_web_forsamling','emi_web_emigration_year','emi_web_akt_nr',
                        'date_created','file_format','resolution','secrecy'])
                    ->flatten();
                break;

            case(24):

                $model = new SwensonCenterPhotosamlingRecord();
                $detail = SwensonCenterPhotosamlingRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();

                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/24/Archive/Swenson_Center/".substr($detail->file_name, '0','3')."/".str_replace(" ", "_",substr($detail->file_name,3)), now()->addMinutes(60)):false;

                break;

            case(26):

                $model = new RsPersonalHistoryRecord();
                $detail = RsPersonalHistoryRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(27):

                $model = new SwedishUsaCentersEmiPhotoRecord();
                $detail = SwedishUsaCentersEmiPhotoRecord::with('user.organization')->findOrFail($id);
                $theFillables = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
                break;

            case(28):
                $model = new SwedishAmericanBookRecord();
                $detail = SwedishAmericanBookRecord::with('user.organization','SwensonBookData')->findOrFail($id);
//                return $detail;
                $theFillables = collect($model->getFillable())
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
                $media = !empty($detail->file_name)?Storage::disk('s3')->temporaryUrl("archives/5/photos/".$detail->file_name, now()->addMinutes(60)):false;

//                $media = !empty($detail->file_name)?"https://bucketemiweb.s3.eu-north-1.amazonaws.com/archives/5/photos/".$detail->file_name:false;
                break;
            default:
                abort(403);
        }

        $filterAttributes = collect($model->defaultSearchFields());
        $advancedFields = collect($model->searchFields());
        $toBeOrdered = $filterAttributes->merge($advancedFields)->flatten()->filter(
            function( $value, $key) {
                return $value != "---";
            }
        )->all();
        $first =array_values($toBeOrdered);
        $fields =  array_values(array_unique(array_merge($first, $theFillables->toArray())));


//        return $detail;
//        $relatives = $detail->archive->relatives->where('record_id', $id);
//        $images = $detail->archive->ImagesInArchive->where('record_id', $id);
        $archive_details = $archive;
        $media = isset($media)?$media:false;


//        return $detail;

        return view('home.showrecord', compact('detail', 'fields',  'archive_details','media'));

    }

    /**
     * @param $arch
     * @param $id
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function print($arch, $id){
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

            case(22):

                $model = new BevaringensLevnadsbeskrivningarRecord();
                $detail = BevaringensLevnadsbeskrivningarRecord::with('user.organization')->findOrFail($id);
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

            case(24):

                $model = new SwensonCenterPhotosamlingRecord();
                $detail = SwensonCenterPhotosamlingRecord::with('user.organization')->findOrFail($id);
                $fields = collect($model->getFillable())
                    ->diff(['user_id', 'archive_id', 'organization_id','old_id'])
                    ->flatten();
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
                break;

            default:
                abort(403);
        }



        $relatives = $detail->archive->relatives->where('record_id', $id);
        $images = $detail->archive->ImagesInArchive->where('record_id', $id);
        $archive_details = Archive::find($arch);
        return view('home.print', compact('detail', 'fields', 'relatives', 'images', 'archive_details'));
    }




}
