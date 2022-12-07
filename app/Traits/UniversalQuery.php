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
use App\Models\VarmlandskaNewspaperNoticeRecord;
use MeiliSearch\Client as MeiliSearchClient;
use MeiliSearch\Endpoints\Indexes;

trait UniversalQuery{



    private function QueryDenmarkEmigration( $input){
        $result = DenmarkEmigration::select('id');

        $exec = 0;

////        if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
        //        if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
//        if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
        $exec = $exec+1;
        }
//        if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
        $exec = $exec+1;
        }


        if($exec>=1){return $result->count('id');}
        else { return 0; }

    }

    private function QuerySwedishChurchEmigrationRecord( $input){
//        retur;
        $result = SwedishChurchEmigrationRecord::select('id');

        $exec = 0;
//        if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
        $exec = $exec+1;
        }
//        if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
        $exec = $exec+1;
        }
        if(!empty($input['parish'])){ $result->where('birth_parish', 'LIKE','%'. $input['parish'].'%');
        $exec = $exec+1;
        }
        if(!empty($input['year'])){ $result->whereYear('dob', $input['year'] ); }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryDalslanningarBornInAmericaRecord($input)
    {

        $result = DalslanningarBornInAmericaRecord::select('id');

        $exec = 0;
        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishEmigrationStatisticsRecord($input)
    {

        $result = SwedishEmigrationStatisticsRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
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

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryBrodernaLarssonArchiveRecord($input)
    {

        $result = BrodernaLarssonArchiveRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }


        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishPortPassengerListRecord($input)
    {

        $result = SwedishPortPassengerListRecord::select('id');

        $exec = 0;
//        if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            if(!empty($input['qry_first_name'])){ $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
        $exec = $exec+1;
        }
//        if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            if(!empty($input['qry_last_name'])){ $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
        $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishAmericanChurchArchiveRecord($input)
    {

        $result = SwedishAmericanChurchArchiveRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
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

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryNewYorkPassengerRecord($input)
    {

        $result = NewYorkPassengerRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year', $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishChurchImmigrantRecord($input)
    {

        $result = SwedishChurchImmigrantRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }
        if (!empty($input['year'])) {
            $result->where('birth_date',  $input['year']);
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishEmigrantViaKristianiaRecord($input)
    {

        $result = SwedishEmigrantViaKristianiaRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishImmigrationStatisticsRecord($input)
    {

        $result = SwedishImmigrationStatisticsRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year',   $input['year']);
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryLarssonEmigrantPopularRecord($input)
    {

        $result = LarssonEmigrantPopularRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['parish'])) {
            $result->where('home_parish',  'LIKE','%'. $input['parish'].'%');
            $exec = $exec+1;

        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryJohnEricssonsArchiveRecord($input)
    {

        $result = JohnEricssonsArchiveRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryNorwegianChurchImmigrantRecord($input)
    {

        $result = NorwegianChurchImmigrantRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryMormonShipPassengerRecord($input)
    {

        $result = MormonShipPassengerRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }


        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishAmericanMemberRecord($input)
    {

        $result = SwedishAmericanMemberRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
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

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedeInAlaskaRecord($input)
    {

        $result = SwedeInAlaskaRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryVarmlandskaNewspaperNoticeRecord($input)
    {

        $result = VarmlandskaNewspaperNoticeRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_year',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryNorwayEmigrationRecord($input)
    {

        $result = NorwayEmigrationRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date', $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QueryIcelandEmigrationRecord($input)
    {

        $result = IcelandEmigrationRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('date_of_birth',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }


    private function QuerySwedishAmericanJubileeRecord($input)
    {

        $result = SwedishAmericanJubileeRecord::select('id');

        $exec = 0;

        if (!empty($input['title'])) {
//            $result->whereFullText('title', $input['title']);
            $result->where('title', 'like', '%'. $input['title'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['description'])) {
//            $result->whereFullText('description',  $input['description']);
//            $result->whereFullText('description',  $input['description']);
            $result->where('description', 'like', '%'. $input['description'] .'%');

            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('date_created',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }
    }

    private function QuerySwedishAmericanBookRecord($input)
    {

        $result = SwedishAmericanBookRecord::select('id');

        $exec = 0;

        if (!empty($input['qry_first_name'])) {
//            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $result->where('first_name', 'like', '%'. $input['qry_first_name'] .'%');
            $exec = $exec+1;

        }
        if (!empty($input['qry_last_name'])) {
//            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $result->where('last_name', 'like', '%'. $input['qry_last_name'] .'%');
            $exec = $exec+1;

        }

        if (!empty($input['year'])) {
            $result->whereYear('birth_date',  $input['year']);
            $exec = $exec+1;
        }

        if($exec>=1){return $result->count('id');}
        else { return 0; }

    }



}
