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

    private function QryableItems($all_request)
    {
        $r = array_intersect_key(Arr::whereNotNull($all_request),
            array_flip(preg_grep('/^qry_/', array_keys(Arr::whereNotNull($all_request)))));
//        return $r;
        $qryable_items = [];
        if(!empty($r)){
            foreach($r as $r => $fields)
            {
                $qryable_items[] = $r;
//                $field = Str::of($r)->after('qry');
            }
        }
        return $qryable_items;


    }

    private function QueryMatch($quryables,$result, $all_request)
    {
        foreach($quryables as  $quryable)
        {
            if($all_request[$quryable]['value'] != null){
                $field_scope= Str::of($quryable)->after('qry_');
                if($all_request[$quryable]['method'] == null && ($field_scope === "first_name" or $field_scope === "last_name"))
                {
                    {  $result->whereFullText($field_scope, $all_request[$quryable]['value']);}
                }
                if($all_request[$quryable]['method'] == null && ($field_scope !== "first_name" and $field_scope !== "last_name"))
                {
                    {  $result->where($field_scope,'like', '%'.$all_request[$quryable]['value'].'%');}
                }
                if($all_request[$quryable]['method'] === "start" ) {  $result->where($field_scope,'like', $all_request[$quryable]['value'].'%');}
                if($all_request[$quryable]['method'] === "end" ) {  $result->where($field_scope,'like', '%'.$all_request[$quryable]['value']);}
                if($all_request[$quryable]['method'] === "exact" ) {  $result->where($field_scope, $all_request[$quryable]['value']);}

            }

        }
//        return $field_scope;
        return $result->paginate(100);
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
                    $result->whereYear($fieldname,$fieldvalue->format('Y-m-d'));
                }

            }






//            for everything else
            else{
                $result->where($fieldname, $fieldvalue);




//                if($all_request['action']==="filter"){
//                    $result->where($fieldname, $fieldvalue);
//                }
//                if($all_request['action']==="search"){
////
//
//                    if($fieldname === 'first_name' or  $fieldname === 'last_name' or $fieldname === 'title' or $fieldname==='description')
//
//                        $result->whereFullText($fieldname, $fieldvalue);
//                    }
//
//                    if($fieldname !== 'first_name' and  $fieldname !== 'last_name' and $fieldname !== 'title' and $fieldname!=='description')
//                    {
//
//                        $result->where($fieldname, $fieldvalue);
//                    }
//
//
//
//
//
            }
        }
        return $result->paginate(100,$fieldsToDisply);


//        return $result->cursorPaginate(100,$fieldsToDisply);
//        return $result->simplePaginate(100,$fieldsToDisply);

//        return $result->get($fieldsToDisply);
    }

    private function provinces()
    {
        return [
            "Älvsborg" => "Älvsborg",
            "Blekinge" => "Blekinge",
            "Gävleborg" => "Gävleborg",
            "Göteborgs och Bohus" => "Göteborgs och Bohus",
            "Gotland" => "Gotland",
            "Halland" => "Halland",
            "Jämtland" => "Jämtland",
            "Jönköping" => "Jönköping",
            "Kalmar" => "Kalmar",
            "Kopparberg" => "Kopparberg",
            "Kristianstad" => "Kristianstad",
            "Kronoberg" => "Kronoberg",
            "Malmöhus" => "Malmöhus",
            "Norrbotten" => "Norrbotten",
            "Örebro" => "Örebro",
            "Östergötland" => "Östergötland",
            "Skaraborg" => "Skaraborg",
            "Södermanland" => "Södermanland",
            "Stockholm" => "Stockholm",
            "Uppsala" => "Uppsala",
            "Värmland" => "Värmland",
            "Västerbotten" => "Västerbotten",
            "Västernorrland" => "Västernorrland",
            "Västmanland" => "Västmanland"
        ];
    }
}
