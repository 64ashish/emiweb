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

trait FromArchive{



    private function RecordIs($archive, $record)
    {
        switch ($archive) {
            case(1):
                $model = DenmarkEmigration::findOrFail($record);
                break;

            case(2):
//                    add last_name1 in validation for this to work
                $model = SwedishAmericanChurchArchiveRecord::findOrFail($record);
                break;

            case(3):
//                    update given and surname to first and last name
                $model = NewYorkPassengerRecord::findOrFail($record);
                break;

            case(4):

                $model = SwedishPortPassengerListRecord::findOrFail($record);
                break;

            case(5):
                $model = SwedishChurchEmigrationRecord::findOrFail($record);
                break;

            case(6):
                $model = SwedishChurchImmigrantRecord::findOrFail($record);
                break;

            case(7):
                $model = SwedishEmigrantViaKristianiaRecord::findOrFail($record);
                break;

            case(8):
                $model = SwedishImmigrationStatisticsRecord::findOrFail($record);
                break;

            case(9):
                $model = SwedishEmigrationStatisticsRecord::findOrFail($record);
                break;

            case(10):
                $model = LarssonEmigrantPopularRecord::findOrFail($record);
                break;

            case(11):
                $model = BrodernaLarssonArchiveRecord::findOrFail($record);
                break;

            case(12):
                $model = JohnEricssonsArchiveRecord::findOrFail($record);
                break;

            case(13):
                $model = NorwegianChurchImmigrantRecord::findOrFail($record);
                break;

            case(14):
                $model = MormonShipPassengerRecord::findOrFail($record);
                break;

            case(15):
                $model = SwedishAmericanMemberRecord::findOrFail($record);
                break;

            case(16):
                $model = SwedeInAlaskaRecord::findOrFail($record);
                break;

            case(17):
                $model = VarmlandskaNewspaperNoticeRecord::findOrFail($record);
                break;

            case(18):
                $model = DalslanningarBornInAmericaRecord::findOrFail($record);
                break;

            case(20):
                $model = NorwayEmigrationRecord::findOrFail($record);
                break;

            case(21):
                $model = IcelandEmigrationRecord::findOrFail($record);
                break;

            default:
                abort(403);
        }
        return $model;
    }
}
