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
        $result = DenmarkEmigration::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = DenmarkEmigration::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = DenmarkEmigration::whereIn('id', $ids);
        if(!empty($input['first_name'])){ $result->where('first_name', 'LIKE','%'. $input['first_name'].'%' ); }
        if(!empty($input['last_name'])){ $result->where('last_name', 'LIKE','%'. $input['last_name'].'%'); }

        return $result->get();

    }

    private function QuerySwedishChurchEmigrationRecord( $input){
        $result = SwedishChurchEmigrationRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishChurchEmigrationRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishChurchEmigrationRecord::whereIn('id', $ids);
        if(!empty($input['first_name'])){ $result->where('first_name', 'LIKE','%'. $input['first_name'].'%' ); }
        if(!empty($input['last_name'])){ $result->where('last_name', 'LIKE','%'. $input['last_name'].'%' ); }
        if(!empty($input['parish'])){ $result->where('birth_parish', 'LIKE','%'. $input['parish'].'%' ); }
        if(!empty($input['year'])){ $result->where('dob', 'LIKE','%'. $input['year'].'%' ); }
        return $result->get();
    }

    private function QueryDalslanningarBornInAmericaRecord($input)
    {
        $result = DalslanningarBornInAmericaRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = DalslanningarBornInAmericaRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = DalslanningarBornInAmericaRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->Where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->Where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QuerySwedishEmigrationStatisticsRecord($input)
    {
        $result = SwedishEmigrationStatisticsRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishEmigrationStatisticsRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishEmigrationStatisticsRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('from_parish',  'LIKE','%'. $input['parish'].'%');
        }
        if (!empty($input['year'])) {
            $result->where('birth_year',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryBrodernaLarssonArchiveRecord($input)
    {
        $result = BrodernaLarssonArchiveRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = BrodernaLarssonArchiveRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = BrodernaLarssonArchiveRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
        }

        return $result->get();
    }

    private function QuerySwedishPortPassengerListRecord($input)
    {
        $result = SwedishPortPassengerListRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishPortPassengerListRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishPortPassengerListRecord::whereIn('id', $ids);
        if(!empty($input['first_name'])){ $result->where('first_name', 'LIKE','%'. $input['first_name'].'%'); }
        if(!empty($input['last_name'])){ $result->where('last_name', 'LIKE','%'. $input['last_name'].'%'); }
        return $result->get();
    }

    private function QuerySwedishAmericanChurchArchiveRecord($input)
    {
        $result = SwedishAmericanChurchArchiveRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishAmericanChurchArchiveRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishAmericanChurchArchiveRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryNewYorkPassengerRecord($input)
    {
        $result = NewYorkPassengerRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = NewYorkPassengerRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = NewYorkPassengerRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_year',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QuerySwedishChurchImmigrantRecord($input)
    {
        $result = SwedishChurchImmigrantRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishChurchImmigrantRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishChurchImmigrantRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QuerySwedishEmigrantViaKristianiaRecord($input)
    {
        $result = SwedishEmigrantViaKristianiaRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishEmigrantViaKristianiaRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishEmigrantViaKristianiaRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        return $result->get();
    }

    private function QuerySwedishImmigrationStatisticsRecord($input)
    {
        $result = SwedishImmigrationStatisticsRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishImmigrationStatisticsRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishImmigrationStatisticsRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_year',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryLarssonEmigrantPopularRecord($input)
    {
        $result = LarssonEmigrantPopularRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = LarssonEmigrantPopularRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = LarssonEmigrantPopularRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
        }
        return $result->get();
    }

    private function QueryJohnEricssonsArchiveRecord($input)
    {
        $result = JohnEricssonsArchiveRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = JohnEricssonsArchiveRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = JohnEricssonsArchiveRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        return $result->get();
    }

    private function QueryNorwegianChurchImmigrantRecord($input)
    {
        $result = NorwegianChurchImmigrantRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = NorwegianChurchImmigrantRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = NorwegianChurchImmigrantRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryMormonShipPassengerRecord($input)
    {
        $result = MormonShipPassengerRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = MormonShipPassengerRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = MormonShipPassengerRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        return $result->get();
    }

    private function QuerySwedishAmericanMemberRecord($input)
    {
        $result = SwedishAmericanMemberRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedishAmericanMemberRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedishAmericanMemberRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QuerySwedeInAlaskaRecord($input)
    {
        $result = SwedeInAlaskaRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = SwedeInAlaskaRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = SwedeInAlaskaRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryVarmlandskaNewspaperNoticeRecord($input)
    {
        $result = VarmlandskaNewspaperNoticeRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = VarmlandskaNewspaperNoticeRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = VarmlandskaNewspaperNoticeRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_year',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryNorwayEmigrationRecord($input)
    {
        $result = NorwayEmigrationRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = NorwayEmigrationRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = NorwayEmigrationRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('birth_date',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }

    private function QueryIcelandEmigrationRecord($input)
    {
        $result = IcelandEmigrationRecord::query();
//        $query_raw = trim($input['first_name']." ".!empty($input['last_name']));
//
//        $meliesearchraw = IcelandEmigrationRecord::search($query_raw,
//            function (Indexes $meilisearch, $query, $options){
//                $options['limit'] = 2000;
//                return $meilisearch->search($query, $options);
//            })->raw();
//        $ids = collect($meliesearchraw['hits'])->pluck('id');
//        $result = IcelandEmigrationRecord::whereIn('id', $ids);
        if (!empty($input['first_name'])) {
            $result->where('first_name',  'LIKE','%'. $input['first_name'].'%');
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name',  'LIKE','%'. $input['last_name'].'%');
        }

        if (!empty($input['year'])) {
            $result->where('date_of_birth',  'LIKE','%'. $input['year'].'%');
        }
        return $result->get();
    }




}
