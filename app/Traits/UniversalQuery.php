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
        $exec = 0;

        if(!empty($input['first_name'])){ $result->whereFullText('first_name', $input['first_name']);
        $exec = $exec+1;
        }
        if(!empty($input['last_name'])){ $result->whereFullText('last_name', $input['last_name']);
        $exec = $exec+1;
        }


        if($exec>=1){return $result->get('id')->count();}else { return 0; }

    }

    private function QuerySwedishChurchEmigrationRecord( $input){
        $result = SwedishChurchEmigrationRecord::query();
        $exec = 0;
        if(!empty($input['first_name'])){ $result->whereFullText('first_name', $input['first_name']);
        $exec = $exec+1;
        }
        if(!empty($input['last_name'])){ $result->whereFullText('last_name', $input['last_name']);
        $exec = $exec+1;
        }
        if(!empty($input['parish'])){ $result->where('birth_parish', 'LIKE','%'. $input['parish'].'%');
        $exec = $exec+1;
        }
        if(!empty($input['year'])){ $result->whereYear('dob', $input['year'] ); }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryDalslanningarBornInAmericaRecord($input)
    {
        $result = DalslanningarBornInAmericaRecord::query();
        $exec = 0;
        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishEmigrationStatisticsRecord($input)
    {
        $result = SwedishEmigrationStatisticsRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('from_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->whereYear('birth_year',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryBrodernaLarssonArchiveRecord($input)
    {
        $result = BrodernaLarssonArchiveRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }


        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishPortPassengerListRecord($input)
    {
        $result = SwedishPortPassengerListRecord::query();
        $exec = 0;
        if(!empty($input['first_name'])){ $result->whereFullText('first_name', $input['first_name']);
        $exec = $exec+1;
        }
        if(!empty($input['last_name'])){ $result->whereFullText('last_name', $input['last_name']);
        $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishAmericanChurchArchiveRecord($input)
    {
        $result = SwedishAmericanChurchArchiveRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->whereYear('birth_date', $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryNewYorkPassengerRecord($input)
    {
        $result = NewYorkPassengerRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year', $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishChurchImmigrantRecord($input)
    {
        $result = SwedishChurchImmigrantRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  $input['year']);
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishEmigrantViaKristianiaRecord($input)
    {
        $result = SwedishEmigrantViaKristianiaRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishImmigrationStatisticsRecord($input)
    {
        $result = SwedishImmigrationStatisticsRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year',   $input['year']);
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryLarssonEmigrantPopularRecord($input)
    {
        $result = LarssonEmigrantPopularRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryJohnEricssonsArchiveRecord($input)
    {
        $result = JohnEricssonsArchiveRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryNorwegianChurchImmigrantRecord($input)
    {
        $result = NorwegianChurchImmigrantRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryMormonShipPassengerRecord($input)
    {
        $result = MormonShipPassengerRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }


        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedishAmericanMemberRecord($input)
    {
        $result = SwedishAmericanMemberRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QuerySwedeInAlaskaRecord($input)
    {
        $result = SwedeInAlaskaRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryVarmlandskaNewspaperNoticeRecord($input)
    {
        $result = VarmlandskaNewspaperNoticeRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryNorwayEmigrationRecord($input)
    {
        $result = NorwayEmigrationRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date', $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }

    private function QueryIcelandEmigrationRecord($input)
    {
        $result = IcelandEmigrationRecord::query();
        $exec = 0;

        if (!empty($input['first_name'])) {
            $result->whereFullText('first_name', $input['first_name']);
            $exec = $exec+1;

        }
        if (!empty($input['last_name'])) {
            $result->whereFullText('last_name',  $input['last_name']);
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('date_of_birth',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->get('id')->count();}else { return 0; }
    }




}
