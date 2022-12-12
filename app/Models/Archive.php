<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Archive extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'name', 'detail','place','total_records', 'link', 'owner_detail'
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

    public function SwedishAmericanJubileeRecords()
    {
        return $this->hasMany(SwedishAmericanJubileeRecord::class);
    }

    public function NorthenPacificRailwayCompanyRecord()
    {
        return $this->hasMany(NorthenPacificRailwayCompanyRecord::class);
    }

    public function ImagesInArchive()
    {
        return $this->hasMany(ImagesInArchive::class);
    }

    public function relatives(){
        return $this->hasMany(Relatives::class);
    }

    public function RsPersonalHistoryRecords()
    {
        return $this->hasMany(RsPersonalHistoryRecord::class);
    }

    public function SwedishUsaCentersEmiPhotoRecords()
    {
        return $this->hasMany(SwedishUsaCentersEmiPhotoRecord::class);
    }

    public function SwensonCenterPhotosamlingRecords()
    {
        return $this->hasMany(SwensonCenterPhotosamlingRecord::class);
    }





}
