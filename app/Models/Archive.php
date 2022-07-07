<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Archive extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name', 'detail','place'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'archive_organization');
    }

    public function imageCollections()
    {
        return $this->belongsToMany(ImageCollection::class, 'archive_image_collection');
    }

    public function denmarkEmigrations(){
        return $this->hasMany(DenmarkEmigration::class);
    }


    public function SwedishChurchEmigrationRecord(){
        return $this->hasMany(SwedishChurchEmigrationRecord::class);
    }


    public function DalslanningarBornInAmericaRecord() {
        return $this->hasMany(DalslanningarBornInAmericaRecord::class);
    }

    public function SwedishEmigrationStatisticsRecord()
    {
        return $this->hasMany(SwedishEmigrationStatisticsRecord::class);
    }

    public function BrodernaLarssonArchiveRecords()
    {
        return $this->hasMany(BrodernaLarssonArchiveRecord::class);
    }

    public function NorwayEmigrantRecords(){
        return $this->hasMany(NorwayEmigrationRecord::class);
    }

    public function IcelandEmigrationRecords()
    {
        return $this->hasMany( IcelandEmigrationRecord::class);
    }

    public function SwedishAmericanChurchArchiveRecords()
    {
        return $this->hasMany(SwedishAmericanChurchArchiveRecord::class);
    }

    public function NewYorkPassengerRecords()
    {
        return $this->hasMany(NewYorkPassengerRecord::class);
    }

    public function SwedishPortPassengerListRecords()
    {
        return $this->hasMany(SwedishPortPassengerListRecord::class);
    }

    public function SwedishChurchImmigrantRecords()
    {
        return $this->hasMany(SwedishChurchImmigrantRecord::class);
    }

    public function SwedishEmigrantViaKristianiaRecords()
    {
        return $this->hasMany(SwedishEmigrantViaKristianiaRecord::class);
    }

    public function SwedishImmigrationStatisticsRecords()
    {
        return $this->hasMany(SwedishImmigrationStatisticsRecord::class);
    }

    public function LarssonEmigrantPopularRecords()
    {
        return $this->hasMany(LarssonEmigrantPopularRecord::class);
    }

    public function JohnEricssonsArchiveRecords()
    {
        return $this->hasMany(JohnEricssonsArchiveRecord::class);
    }
    public function MormonShipPassengerRecords()
    {
        return $this->hasMany(MormonShipPassengerRecord::class);
    }

    public function NorwegianChurchImmigrantRecords()
    {
        return $this->hasMany(NorwegianChurchImmigrantRecord::class);
    }

    public function SwedeInAlaskaRecords()
    {
        return $this->hasMany(SwedeInAlaskaRecord::class);
    }

    public function SwedishAmericanMemberRecords()
    {
        return $this->hasMany(SwedishAmericanMemberRecord::class);
    }

    public function VarmlandskaNewspaperNoticeRecords()
    {
        return $this->hasMany(VarmlandskaNewspaperNoticeRecord::class);
    }

    public function ImagesInArchive()
    {
        return $this->hasMany(ImagesInArchive::class);
    }


    public function getRecordTotalAttribute($id)
    {
        if( $this->id == 1){
//            return DenmarkEmigration::count();
            return ceil(377745/1000)*1000;
        }
        if( $this->id == 2){
//            return DenmarkEmigration::count();
            return ceil(31208/1000)*1000;
        }
        if( $this->id == 3){
//            return DenmarkEmigration::count();
            return ceil(343500/1000)*1000;
        }
        if( $this->id == 4){
//            return DenmarkEmigration::count();
            return ceil(1419962/1000)*1000;
        }
        if( $this->id == 5){
//            return SwedishChurchEmigrationRecord::count();
            return ceil(935250/1000)*1000;
        }
        if( $this->id == 6){
//            return SwedishChurchEmigrationRecord::count();
            return ceil(450286/1000)*1000;
        }
        if( $this->id == 7){
//            return SwedishChurchEmigrationRecord::count();
            return ceil(17767/1000)*1000;
        }
        if( $this->id == 8){
//            return SwedishChurchEmigrationRecord::count();
            return ceil(540056/1000)*1000;
        }
        if( $this->id == 9){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(1451365/1000)*1000;
        }
        if( $this->id == 10){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(62508/1000)*1000;
        }
        if( $this->id == 11){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(6111/1000)*1000;
        }
        if( $this->id == 12){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(44/1000)*1000;
        }
        if( $this->id == 13){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(3190/1000)*1000;
        }
        if( $this->id == 14){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(26938/1000)*1000;
        }
        if( $this->id == 15){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(31208/1000)*1000;
        }
        if( $this->id == 16){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(3082/1000)*1000;
        }
        if( $this->id == 17){
//            return SwedishEmigrationStatisticsRecord::count();
            return ceil(4297/1000)*1000;
        }

        if( $this->id == 18){
//            return DalslanningarBornInAmericaRecord::count();
            return ceil(5305/1000)*1000;

        }

        if( $this->id == 20){
//            return BrodernaLarssonArchiveRecord::count();
            return ceil(81168/1000)*1000;
        }
        if( $this->id == 21){
//            return BrodernaLarssonArchiveRecord::count();
            return ceil(1865/1000)*1000;
        }
            return 0;
    }




}
