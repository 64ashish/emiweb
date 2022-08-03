<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait SearchOrFilter
{

    private function CarbonizeDates($all_request)
    {
        $r = array_intersect_key(Arr::whereNotNull($all_request),
            array_flip(preg_grep('/^array_/', array_keys(Arr::whereNotNull($all_request)))));
//        return $r;

        $date_keys = [];
        $field_data = [];
        if(!empty($r)){
            foreach ($r as $r => $dates) {
                $date_keys[] = $r;
                $field = Str::of($r)->after('array_');

                if (count(Arr::whereNotNull(Arr::flatten($dates))) > 0) {
                    $field_data["$field"] = Carbon::createFromDate(
                        !is_null($dates['year']) ? $dates['year'] : "0001",
                        !is_null($dates['month']) ? $dates['month'] : "01",
                        !is_null($dates['day']) ? $dates['day'] : "01"
                    );
                }
            }
        }


        return compact('date_keys', 'field_data');


    }


    private function FilterQuery( $inputFields, $result, $all_request)
    {
//        return $inputFields;
        foreach($inputFields as  $fieldname => $fieldvalue) {
//            for dates
            if(!(str_contains(str_replace('_', ' ', $fieldname), 'date') or !str_contains(str_replace('_', ' ', $fieldname), 'dob') ) )
            {
                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and !empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereDate($fieldname, $fieldvalue->format('Y/m/d'));
                }

                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereYear($fieldname,$fieldvalue->format('Y'))
                        ->whereMonth($fieldname,$fieldvalue->format('m'));
                }

                if(!empty($all_request['array_'.$fieldname]['year']) and empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereYear($fieldname,$fieldvalue->format('Y'));
                }

            }
//            for everything else
            else{
                $result->where($fieldname, $fieldvalue);
            }
        }
        return $result->paginate(100);
    }
}
