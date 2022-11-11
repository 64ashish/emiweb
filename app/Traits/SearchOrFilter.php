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




//                return $dates;
                if (count(Arr::whereNotNull(Arr::flatten($dates))) > 0) {
                    $field_data["$field"] = Carbon::createFromDate(
                        $dates['year'] != null ? $dates['year'] : "0001",
                        $dates['month'] != null ? $dates['month'] : "01",
                        $dates['day'] != null ? $dates['day'] : "01"
                    );

                }
            }
        }

//        return $field_data;
        return compact('date_keys', 'field_data');


    }


    private function FilterQuery( $inputFields, $result, $all_request,$fieldsToDisply)
    {

        foreach($inputFields as  $fieldname => $fieldvalue) {

//            for dates
//            echo(!(str_contains(str_replace('_', ' ', $fieldname), 'date') or !str_contains(str_replace('_', ' ', $fieldname), 'dob') ) );
            if((str_contains(str_replace('_', ' ', $fieldname), 'date') or str_contains(str_replace('_', ' ', $fieldname), 'dob') ) )
            {
                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and !empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereDate($fieldname, $fieldvalue->format('Y-m-d'));
                }

                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereYear($fieldname,$fieldvalue->format('Y'))
                        ->whereMonth($fieldname,$fieldvalue->format('m'));
                }

                if(!empty($all_request['array_'.$fieldname]['year']) and empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
                {
                    $result->whereDate($fieldname,$fieldvalue->format('Y-m-d'));
                }

            }
//            for everything else
            else{

                if($all_request['action']==="filter"){
                    $result->where($fieldname, $fieldvalue);
                }
                if($all_request['action']==="search"){
//

                    if($fieldname === 'first_name' or  $fieldname === 'last_name' or $fieldname === 'title' or $fieldname==='description')

                        $result->whereFullText($fieldname, $fieldvalue);
                    }

                    if($fieldname !== 'first_name' and  $fieldname !== 'last_name' and $fieldname !== 'title' and $fieldname!=='description')
                    {

                        $result->where($fieldname, $fieldvalue);
                    }





            }
        }
//        return $result->cursorPaginate(100,$fieldsToDisply);
//        return $result->simplePaginate(100,$fieldsToDisply);
        return $result->paginate(100,$fieldsToDisply);
//        return $result->get($fieldsToDisply);
    }

//    private function SearchQuery( $inputFields, $result, $all_request) {
////        return ;
////        return "this is coming from search query";
//        foreach($inputFields as  $fieldname => $fieldvalue) {
////            for dates
////            echo(!(str_contains(str_replace('_', ' ', $fieldname), 'date') or !str_contains(str_replace('_', ' ', $fieldname), 'dob') ) );
//            if((str_contains(str_replace('_', ' ', $fieldname), 'date') or str_contains(str_replace('_', ' ', $fieldname), 'dob') ) )
//            {
//                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and !empty($all_request['array_'.$fieldname]['day']))
//                {
//                    $result->whereDate($fieldname, $fieldvalue->format('Y-m-d'));
//                }
//
//                if(!empty($all_request['array_'.$fieldname]['year']) and !empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
//                {
//                    $result->whereYear($fieldname,$fieldvalue->format('Y'))
//                        ->whereMonth($fieldname,$fieldvalue->format('m'));
//                }
//
//                if(!empty($all_request['array_'.$fieldname]['year']) and empty($all_request['array_'.$fieldname]['month']) and empty($all_request['array_'.$fieldname]['day']))
//                {
//                    $result->whereYear($fieldname,$fieldvalue->format('Y'));
//                }
//
//            }
////            for everything else
//            else{
//
//
//            }
//        }
//        return $result->paginate(100);
//    }
}
