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

trait UniversalQuery{

    private function QueryDenmarkEmigration( $input){
        $result = DenmarkEmigration::query();
        if(!empty($input['first_name'])){ $result->where('first_name',$input['first_name']); }
        if(!empty($input['last_name'])){ $result->where('last_name',$input['last_name']); }
        return $result->get();

    }

    private function QuerySwedishChurchEmigrationRecord( $input){
        $result = SwedishChurchEmigrationRecord::query();
        if(!empty($input['first_name'])){ $result->where('first_name',$input['first_name']); }
        if(!empty($input['last_name'])){ $result->where('last_name',$input['last_name']); }
        if(!empty($input['parish'])){ $result->where('birth_parish',$input['parish']); }
        if(!empty($input['year'])){ $result->where('year',$input['year']); }
        return $result->get();
    }

    private function QueryDalslanningarBornInAmericaRecord($input)
    {
        $result = DalslanningarBornInAmericaRecord::query();
        if (!empty($input['first_name'])) {
            $result->Where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->Where('last_name', $input['last_name']);
        }
        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QuerySwedishEmigrationStatisticsRecord($input)
    {
        $result = SwedishEmigrationStatisticsRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('from_parish', $input['parish']);
        }
        if (!empty($input['year'])) {
            $result->where('birth_year', $input['year']);
        }
        return $result->get();
    }

    private function QueryBrodernaLarssonArchiveRecord($input)
    {
        $result = BrodernaLarssonArchiveRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('home_parish', $input['parish']);
        }

        return $result->get();
    }

    private function QuerySwedishPortPassengerListRecord($input)
    {
        $result = SwedishPortPassengerListRecord::query();
        if(!empty($input['first_name'])){ $result->where('first_name',$input['first_name']); }
        if(!empty($input['last_name'])){ $result->where('last_name',$input['last_name']); }
        return $result->get();
    }

    private function QuerySwedishAmericanChurchArchiveRecord($input)
    {
        $result = SwedishAmericanChurchArchiveRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish', $input['birth_parish']);
        }
        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QueryNewYorkPassengerRecord($input)
    {
        $result = NewYorkPassengerRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_year', $input['year']);
        }
        return $result->get();
    }

    private function QuerySwedishChurchImmigrantRecord($input)
    {
        $result = SwedishChurchImmigrantRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish', $input['parish']);
        }
        if (!empty($input['year'])) {
            $result->where('birth_date', $input['yaer']);
        }
        return $result->get();
    }

    private function QuerySwedishEmigrantViaKristianiaRecord($input)
    {
        $result = SwedishEmigrantViaKristianiaRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        return $result->get();
    }

    private function QuerySwedishImmigrationStatisticsRecord($input)
    {
        $result = SwedishImmigrationStatisticsRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_year', $input['year']);
        }
        return $result->get();
    }

    private function QueryLarssonEmigrantPopularRecord($input)
    {
        $result = LarssonEmigrantPopularRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('home_parish', $input['parish']);
        }
        return $result->get();
    }

    private function QueryJohnEricssonsArchiveRecord($input)
    {
        $result = JohnEricssonsArchiveRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        return $result->get();
    }

    private function QueryNorwegianChurchImmigrantRecord($input)
    {
        $result = NorwegianChurchImmigrantRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QueryMormonShipPassengerRecord($input)
    {
        $result = MormonShipPassengerRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        return $result->get();
    }

    private function QuerySwedishAmericanMemberRecord($input)
    {
        $result = SwedishAmericanMemberRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }
        if (!empty($input['parish'])) {
            $result->where('birth_parish', $input['parish']);
        }
        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QuerySwedeInAlaskaRecord($input)
    {
        $result = SwedeInAlaskaRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QueryVarmlandskaNewspaperNoticeRecord($input)
    {
        $result = VarmlandskaNewspaperNoticeRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_year', $input['year']);
        }
        return $result->get();
    }

    private function QueryNorwayEmigrationRecord($input)
    {
        $result = NorwayEmigrationRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('birth_date', $input['year']);
        }
        return $result->get();
    }

    private function QueryIcelandEmigrationRecord($input)
    {
        $result = IcelandEmigrationRecord::query();
        if (!empty($input['first_name'])) {
            $result->where('first_name', $input['first_name']);
        }
        if (!empty($input['last_name'])) {
            $result->where('last_name', $input['last_name']);
        }

        if (!empty($input['year'])) {
            $result->where('date_of_birth', $input['year']);
        }
        return $result->get();
    }




}
