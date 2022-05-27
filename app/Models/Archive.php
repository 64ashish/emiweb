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

    public function getRecordTotalAttribute($id)
    {
        if( $this->id == 1){
//            return DenmarkEmigration::count();
            return 374572;
        }
        if( $this->id == 5){
//            return SwedishChurchEmigrationRecord::count();
            return 947759;
        }
        if( $this->id == 9){
//            return SwedishEmigrationStatisticsRecord::count();
            return 1577390;
        }
        if( $this->id == 18){
//            return DalslanningarBornInAmericaRecord::count();
            return 5305;

        }
        if( $this->id == 11){
//            return BrodernaLarssonArchiveRecord::count();
            return 6111;
        }
            return 0;
    }


}
