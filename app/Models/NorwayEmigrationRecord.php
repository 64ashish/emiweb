<?php

namespace App\Models;

use App\Traits\RecordCount;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class NorwayEmigrationRecord extends Model
{
    use HasFactory, Searchable, RecordCount;
}
