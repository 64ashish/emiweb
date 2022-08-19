<?php

namespace App\Http\Controllers\Record;

use App\Http\Controllers\Controller;
use App\Traits\SearchOrFilter;
use Illuminate\Http\Request;
use MeiliSearch\Client as MeiliSearchClient;

class BevaringensLevnadsbeskrivningarRecordController extends Controller
{
    //
    use SearchOrFilter;

    public function __construct(MeiliSearchClient $meilisearch)
    {
        $this->meilisearch = $meilisearch;
    }

}
