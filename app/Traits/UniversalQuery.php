<?php

namespace App\Traits;

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
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

trait UniversalQuery{

    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

    private function QueryDenmarkEmigration( $input){
//        $result = DenmarkEmigration::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);

        $meliesearchraw = DenmarkEmigration::search($query_raw)->simplePaginateRaw(100);
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = DenmarkEmigration::whereIn('id', $ids);
//        if(!empty($input['first_name'])){ $result->where('first_name', 'LIKE','%'. $input['first_name'].'%' ); }
//        if(!empty($input['last_name'])){ $result->where('last_name', 'LIKE','%'. $input['last_name'].'%'); }

        return $meliesearchraw['nbHits'];

    }

    private function QuerySwedishChurchEmigrationRecord( $input){
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);

        $meliesearchraw = SwedishChurchEmigrationRecord::search($query_raw)->simplePaginateRaw(100);


        return $meliesearchraw['nbHits'];
    }

    private function QueryDalslanningarBornInAmericaRecord($input)
    {
        $result = DalslanningarBornInAmericaRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = DalslanningarBornInAmericaRecord::search($query_raw)->simplePaginateRaw(100);


        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishEmigrationStatisticsRecord($input)
    {
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = SwedishEmigrationStatisticsRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryBrodernaLarssonArchiveRecord($input)
    {
        $result = BrodernaLarssonArchiveRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = BrodernaLarssonArchiveRecord::search($query_raw)->simplePaginateRaw(100);


        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishPortPassengerListRecord($input)
    {
//        $result = SwedishPortPassengerListRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);

//        dd($query_raw);
//
        $meliesearchraw = SwedishPortPassengerListRecord::search($query_raw)
            ->simplePaginateRaw(100);
//        dd($meliesearchraw->total());
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishPortPassengerListRecord::whereIn('id', $ids);
//        if(!empty($input['first_name'])){ $result->where('first_name', 'LIKE','%'. $input['first_name'].'%'); }
//        if(!empty($input['last_name'])){ $result->where('last_name', 'LIKE','%'. $input['last_name'].'%'); }
        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishAmericanChurchArchiveRecord($input)
    {

        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);

//        dd($query_raw);

        $meliesearchraw = SwedishAmericanChurchArchiveRecord::search($query_raw)->simplePaginateRaw(100);

//        dd($meliesearchraw);

        return $meliesearchraw['nbHits'];
    }

    private function QueryNewYorkPassengerRecord($input)
    {

        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = NewYorkPassengerRecord::search($query_raw)->simplePaginateRaw(100);
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = NewYorkPassengerRecord::whereIn('id', $ids);

        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishChurchImmigrantRecord($input)
    {
        $result = SwedishChurchImmigrantRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);

        $meliesearchraw = SwedishChurchImmigrantRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishEmigrantViaKristianiaRecord($input)
    {
        $result = SwedishEmigrantViaKristianiaRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = SwedishEmigrantViaKristianiaRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishImmigrationStatisticsRecord($input)
    {
        $result = SwedishImmigrationStatisticsRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = SwedishImmigrationStatisticsRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryLarssonEmigrantPopularRecord($input)
    {
        $result = LarssonEmigrantPopularRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = LarssonEmigrantPopularRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryJohnEricssonsArchiveRecord($input)
    {
        $result = JohnEricssonsArchiveRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = JohnEricssonsArchiveRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryNorwegianChurchImmigrantRecord($input)
    {
        $result = NorwegianChurchImmigrantRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = NorwegianChurchImmigrantRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryMormonShipPassengerRecord($input)
    {
        $result = MormonShipPassengerRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = MormonShipPassengerRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedishAmericanMemberRecord($input)
    {
        $result = SwedishAmericanMemberRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = SwedishAmericanMemberRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QuerySwedeInAlaskaRecord($input)
    {
        $result = SwedeInAlaskaRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = SwedeInAlaskaRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryVarmlandskaNewspaperNoticeRecord($input)
    {
        $result = VarmlandskaNewspaperNoticeRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = VarmlandskaNewspaperNoticeRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryNorwayEmigrationRecord($input)
    {
        $result = NorwayEmigrationRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = NorwayEmigrationRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }

    private function QueryIcelandEmigrationRecord($input)
    {
        $result = IcelandEmigrationRecord::query();
        $first_name = $input['first_name'] ?? "";
        $last_name = $input['last_name'] ?? "";
        $year = $input['year'] ?? "";
        $parish = $input['parish'] ?? "";
        $query_raw = trim($first_name." ".$last_name." ".$year." ".$parish);
//
        $meliesearchraw = IcelandEmigrationRecord::search($query_raw)->simplePaginateRaw(100);

        return $meliesearchraw['nbHits'];
    }




}
