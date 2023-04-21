<?php
namespace App\Services;

use App\Models\BevaringensLevnadsbeskrivningarRecord;
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
use App\Models\VarmlandskaNewspaperNoticeRecord;
use App\Traits\SearchOrFilter;

class FindArchiveService
{
    use SearchOrFilter;

    public function getSelectedArchive($archiveId): array
    {
        switch($archiveId) {
            case(1):
                $details = [
                    'model' => new DenmarkEmigration(),
                    'viewfile' => 'dashboard.denmarkemigration.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(2):
                $details = [
                    'model' => new SwedishAmericanChurchArchiveRecord(),
                    'viewfile' => 'dashboard.SwedishAmericanChurchArchiveRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(3):
                $details = [
                    'model' => new NewYorkPassengerRecord(),
                    'viewfile' => 'dashboard.NewYorkPassengerRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(4):
                $details = [
                    'model' => new SwedishPortPassengerListRecord(),
                    'viewfile' => 'dashboard.SwedishPortPassengerListRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(5):
//               return "return redirect";
//                return redirect(route('scerc.search'));
                $details = [
                    'model' => new SwedishChurchEmigrationRecord(),
                    'viewfile' => 'dashboard.swedishchurchemigrationrecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(6):
                $details = [
                    'model' => new SwedishChurchImmigrantRecord(),
                    'viewfile' => 'dashboard.SwedishChurchImmigrantRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(7):
                $details = [
                    'model' => new SwedishEmigrantViaKristianiaRecord(),
                    'viewfile' => 'dashboard.SwedishEmigrantViaKristianiaRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(8):
                $details = [
                    'model' => new SwedishImmigrationStatisticsRecord(),
                    'viewfile' => 'dashboard.SwedishImmigrationStatisticsRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(9):
                $details = [
                    'model' => new SwedishEmigrationStatisticsRecord(),
                    'viewfile' => 'dashboard.scbe.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(10):
                $details = [
                    'model' => new LarssonEmigrantPopularRecord(),
                    'viewfile' => 'dashboard.LarssonEmigrantPopularRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(11):
                $details = [
                    'model' => new BrodernaLarssonArchiveRecord(),
                    'viewfile' => 'dashboard.larsson.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(12):
                $details = [
                    'model' => new JohnEricssonsArchiveRecord(),
                    'viewfile' => 'dashboard.JohnEricssonsArchiveRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(13):
                $details = [
                    'model' => new NorwegianChurchImmigrantRecord(),
                    'viewfile' => 'dashboard.NorwegianChurchImmigrantRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(14):
                $details = [
                    'model' => new MormonShipPassengerRecord(),
                    'viewfile' => 'dashboard.MormonShipPassengerRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(15):
                $details = [
                    'model' => new SwedishAmericanMemberRecord(),
                    'viewfile' => 'dashboard.SwedishAmericanMemberRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(16):
                $details = [
                    'model' => new SwedeInAlaskaRecord(),
                    'viewfile' => 'dashboard.SwedeInAlaskaRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(17):
                $details = [
                    'model' => new VarmlandskaNewspaperNoticeRecord(),
                    'viewfile' => 'dashboard.VarmlandskaNewspaperNoticeRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(18):
                $details = [
                    'model' => new DalslanningarBornInAmericaRecord(),
                    'viewfile' => 'dashboard.dbiar.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(20):
                $details = [
                    'model' => new NorwayEmigrationRecord(),
                    'viewfile' => 'dashboard.norwayemigrationrecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(21):
                $details = [
                    'model' => new IcelandEmigrationRecord(),
                    'viewfile' => 'dashboard.IcelandEmmigrationRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(22):
                $details = [
                    'model' => new BevaringensLevnadsbeskrivningarRecord(),
                    'viewfile' => 'dashboard.blbrc.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(23):
                $details = [
                    'model' => new SwedishAmericanJubileeRecord(),
                    'viewfile' => 'dashboard.SwedishAmericanJubileeRecord.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(24):

                $details = [
                    'model' => new SwensonCenterPhotosamlingRecord(),
                    'viewfile' => 'dashboard.swenphotocenter.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(25):
                $details = [
                    'model' => new NorthenPacificRailwayCompanyRecord(),
                    'viewfile' => 'dashboard.NorthPacificRailwayCo.index',
                    'genders' => $this->getGender()
                ];
                break;

            case(26):
                $details = [
                    'model' => new RsPersonalHistoryRecord(),
                    'viewfile' => 'dashboard.rsphistory.photos',
                    'genders' => $this->getGender()
                ];
                break;

            case(27):
                $details = [
                    'model' => new SwedishUsaCentersEmiPhotoRecord(),
                    'viewfile' => 'dashboard.suscepc.records',
                    'genders' => $this->getGender()
                ];
                break;

            case(28):
                $details = [
                    'model' => new SwedishAmericanBookRecord(),
                    'viewfile' => 'dashboard.sabr.records',
                    'genders' => $this->getGender()
                ];
                break;

            default:
                abort(403);
        }

        return $details;

    }
}
