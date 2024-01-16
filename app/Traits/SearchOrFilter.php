<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait SearchOrFilter
{

    private function CarbonizeDates($all_request): array
    {
        $r = array_intersect_key(Arr::whereNotNull($all_request),
            array_flip(preg_grep('/^array_/', array_keys(Arr::whereNotNull($all_request)))));


        $date_keys = [];
        $field_data = [];



        foreach ($r as $r => $dates) {
            $date_keys[] = $r;
            $field = Str::of($r)->after('array_');

            if (count(Arr::whereNotNull(Arr::flatten($dates))) > 0) {
                $field_data["$field"] = Carbon::createFromDate(
                    Arr::exists($dates, 'year') ? $dates['year'] : "0001",
                    Arr::exists($dates, 'month') ? $dates['month'] : "01",
                    Arr::exists($dates, 'day') ? $dates['day'] : "01"
                );
            }


        }

        return compact('date_keys', 'field_data');
    }


    private function QryableItems($allRequest): array
    {
        $r = array_intersect_key(Arr::whereNotNull($allRequest),
            array_flip(preg_grep('/^qry_/', array_keys(Arr::whereNotNull($allRequest)))));
        $qryableItems = [];
        if(!empty($r)){
            foreach($r as $r => $fields)
            {
                $qryableItems[] = $r;
            }
        }
        return $qryableItems;
    }

    private function QueryMatch($queryables,$result, $all_request): Builder
    {
        // dd($queryables);
        foreach($queryables as  $queryable)
        {
            if(isset($all_request[$queryable]['value'])){
                if($all_request[$queryable]['value'] != null)
                {
                    $field_scope = Str::of($queryable)->after('qry_');

                    //  dd(array_key_exists('method',$all_request[$queryable]));

                    if (array_key_exists('method', $all_request[$queryable])) {
                        switch ($all_request[$queryable]['method']) {
                            case "start":
                                $result->where($field_scope, 'like', $all_request[$queryable]['value'] . '%');
                                break;
                            case "end":
                                $result->where($field_scope, 'like', '%' . $all_request[$queryable]['value']);
                                break;
                            case "exact":
                                $result->where($field_scope, $all_request[$queryable]['value']);
                                break;
                            default:
                                $result->where($field_scope, 'like','%' . $all_request[$queryable]['value'] . '%');
                                break;
                        }
                    } else{
                        $result->where($field_scope, 'like','%' . $all_request[$queryable]['value'] . '%');
                    }

                }
            }
        }

        if(isset($all_request['place_of_birth']) && $all_request['place_of_birth'] != ''){
            $result->where('place_of_birth', 'like','%' . $all_request['place_of_birth'] . '%');
        }

        return $result;

    }

    private function FilterQuery( $inputFields, $result, $all_request,$fieldsToDisply): LengthAwarePaginator
    {


        foreach($inputFields as  $fieldname => $fieldvalue) {

            if ($fieldname !== 'sortBy') {

                if (Str::contains(Str::replace('_', ' ', $fieldname), ['date', 'dob'])
                    && !Str::contains(Str::replace('_', ' ', $fieldname), ['compare'])) {
//                dd('1');
                    $this->applyDateFilter($fieldname, $fieldvalue, $result, $all_request);
                } else if ($fieldname === 'memo') {
//                dd('2');
                    $result->where($fieldname, 'like', '%' . $fieldvalue . '%');
                } else if (!Str::contains(Str::replace('_', ' ', $fieldname), ['compare'])) {
//                dd();
                    $result->where($fieldname, $fieldvalue);
                }
            }
        }



        return $result
//            ->orderBy('first_name', 'asc')
            ->paginate(100,$fieldsToDisply);

    }

    private function applyDateFilter($fieldName, $fieldValue, &$result, $allRequest): Builder
    {
//        dd($allRequest);
//        dd(array_key_exists("compare_birth_date",$allRequest));

        if(
            array_key_exists("compare_$fieldName",$allRequest)
            && Arr::exists($allRequest,"compare_{$fieldName}_check")
        )
        {

            $year = Carbon::createFromDate($allRequest["compare_$fieldName"],"01","01");

            $result->whereBetween(DB::raw("YEAR($fieldName)"),[$fieldValue->format('Y'), $year->format('Y')]);
        } else
        {
            if (!empty($allRequest['array_' . $fieldName]['year']) && !empty($allRequest['array_' . $fieldName]['month']) && !empty($allRequest['array_' . $fieldName]['day']))
            {
                $result->whereDate($fieldName, $fieldValue->format('Y-m-d'));
            } else if (!empty($allRequest['array_' . $fieldName]['year']) && !empty($allRequest['array_' . $fieldName]['month']) && empty($allRequest['array_' . $fieldName]['day']))
            {
                $result->whereYear($fieldName, $fieldValue->format('Y'))
                    ->whereMonth($fieldName, $fieldValue->format('m'));
            } else if (!empty($allRequest['array_' . $fieldName]['year']) && empty($allRequest['array_' . $fieldName]['month']) && empty($allRequest['array_' . $fieldName]['day']))
            {
                $result->whereYear($fieldName, $fieldValue->format('Y-m-d'));
            }
        }


        return $result;
    }



    private function provinces(): array
    {
        $a = array_column($this->ProvincesParishes(), 'county');
        return  array_combine($a, $a);
    }
//
//    private function parishes()
//    {
////        https://www.raymondcamden.com/2022/07/29/building-related-selects-in-alpinejs
//        $parish = array_filter(array_unique(array_merge(...array_column($this->ProvincesParishes(), 'parish'))));
//        sort($parish);
//        return array_combine($parish,$parish);
//    }
//
//    private function getDistinct($model, $fieldName){
//        return $model->select($fieldName)->distinct()->get()->pluck($fieldName,$fieldName);
//    }

    private function ProvincesParishes(): array
    {

        $arr = json_decode('
[
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Asarum"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Aspö"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Augerum"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Backaryd"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Bräkne-Hoby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Edestad"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Elleholm"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Eringsboda"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Flymen"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Fridlevstad"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Förkärla"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Gammalstorp"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Hasslö"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Hjortsberga"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Hällaryd"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Jämjö"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Jämshög"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Kallinge"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Karlshamn"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Karlskrona Amiralitetsförsamling"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Karlskrona stadsförsmling"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Kristianopel"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Kyrkhult"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Listerby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Lösen"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Mjällby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Mörrum"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Nättraby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Ramdala"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Ringamåla"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Ronneby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Ronneby landsförsamling"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Rödeby"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Sillhövda"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Sturkö"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Sölvesborgs landsförsamling"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Sölvesborgs stadsförsamling"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Tjurkö"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Torhamn"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Tving"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Ysane"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Åryd"
    },
    {
        "Länskod": "K",
        "Län": "Blekinge",
        "Församling": "Öljehult"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Akebäck"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Ala"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Alskog"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Alva"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Anga"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Ardre"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Atlingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Barlingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Björke"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Boge"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Bro"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Bunge"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Burs"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Buttle"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Bäl"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Dalhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Eke"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Ekeby"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Eksta"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Endre"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Eskelhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Etelhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fardhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fide"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fleringe"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fole"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Follingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fröjel"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Fårö"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Gammelgarn"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Ganthem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Garde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Gerum"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Gothem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Grötlingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Guldrupe"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hablingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hall"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Halla"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hamra"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hangvar"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Havdhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hejde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hejdeby"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hejnum"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hellvi"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hemse"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hogrän"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Hörsne med Bara"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Klinte"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Kräklingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Källunge"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lau"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Levide"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Linde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lojsta"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lokrume"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lummelunda"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lye"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Lärbro"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Martebo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Mästerby"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Norrlanda"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "När"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Näs"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Othem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Roma"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Rone"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Rute"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Sanda"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Silte"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Sjonhem"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Sproge"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Stenkumla"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Stenkyrka"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Stånga"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Sundre"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Tingstäde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Tofta"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Träkumla"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Vall"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Vallstena"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Vamlingbo"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Viklau"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Visby landsförsamling"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Visby stadsförsamling"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Vänge"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Väskinde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Västergarn"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Västerhejde"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Väte"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Öja"
    },
    {
        "Länskod": "I",
        "Län": "Gotland",
        "Församling": "Östergarn"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Alfta"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Annefors"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Arbrå"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Bergsjö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Bergvik"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Bjuråker"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Bollnäs"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Delsbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Enånger"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Forsa"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Färila"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Gnarp"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Gävle"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Gävle Heliga Trefaldighet"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Gävle Staffan"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hamrånge"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hanebo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Harmånger"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hassela"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hedesunda"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hille"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hofors"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hudiksvall"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hälsingtuna"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Hög"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Högbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Idenor"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ilsbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Järbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Järvsö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Jättendal"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Katrineberg"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Kårböle"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Lingbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ljusdal"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ljusne"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Los"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Mo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Nianfors"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Njutånger"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Norrala"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Norrbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ockelbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ovansjö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ovanåker"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Ramsjö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Rengsjö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Rogsta"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Sandarne"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Sandviken"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Segersta"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Skog"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Svabensverk"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Söderala"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Söderhamn"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Torsåker"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Trönö"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Undersvik"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Valbo"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Voxna"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Åmot"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Årsunda"
    },
    {
        "Länskod": "X",
        "Län": "Gävleborg",
        "Församling": "Österfärnebo"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": null
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Angered"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Askim"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Askum"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Backa"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bergum"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Björketorp"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Björlanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bokenäs"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bottna"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Brastad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bro"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bärfendal"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Bäve"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Dragsmark"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Fiskebäckskil"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Fjällbacka"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Forshälla"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Foss"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Fässberg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Grebbestad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Grinneröd"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Grundsund"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Gullholmen"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Annedal"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs domkyrkoförsamling"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Gamlestad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs garnisonsförsamling"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Haga"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs hosptalsförsamling"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Johanneberg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Karl Johan"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Kristine"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Masthugg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Oskar Fredrik"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Göteborgs Vasa"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Harestad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Hede"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Herrestad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Hogdal"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Hunnebostrand"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Håby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Hålta"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Härryda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Högås"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Jonsered"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Jörlanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Kareby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Klädesholmen"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Klövedal"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Krokstad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Kungshamn"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Kungälv"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Kville"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Kållered"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Käringön"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Landvetter"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lane-Ryr"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lindome"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Ljung"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lommeland"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lundby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lur"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lycke"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lyse"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Lysekil"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Långelanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Malmön"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Marieberg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Marstrand"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Mo"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Mollösund"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Morlanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Myckleby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Naverstad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Norum"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Nya Varvet"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Näsinge"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Partille"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Resteröd"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Romelanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Råda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Rödbo"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Rönnäng"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Röra"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Sanne"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Skaftö"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Skee"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Skredsvik"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Solberga"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Spekeröd"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Stala"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Stenkyrka"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Strömstad"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Styrsö"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Svarteborg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Svenneby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Säve"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Tanum"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Tegneby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Tjärnö"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Torp"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Torsby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Torslanda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Tossene"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Tuve"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Ucklum"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Uddevalla"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Valbo-Ryr"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Valla"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Västra Frölunda"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Ytterby"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Älvsborg"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Öckerö"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Ödsmål"
    },
    {
        "Länskod": "O",
        "Län": "Göteborgs och Bohus",
        "Församling": "Örgryte"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Abild"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Alfshög"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Asige"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Askome"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Breared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Dagsås"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Drängsered"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Eftra"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Eldsberga"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Enslöv"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Fagered"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Falkenberg"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Fjärås"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Frillesås"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Färgaryd"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Förlanda"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Getinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Grimeton"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Grimmared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Gunnarp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Gunnarsjö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Gällared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Gällinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Gödestad"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Halmstad"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Hanhals"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Harplinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Hasslöv"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Hishult"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Holm"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Hunnestad"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Idala"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Jälluntofta"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Karl Gustav"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Kinnared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Knäred"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Krogsered"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Kungsbacka"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Kungsäter"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Kvibille"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Källsjö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Köinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Laholms landsförsamling"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Laholms stadsförsamling"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Landa"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Lindberg"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ljungby"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Långaryd"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Morup"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Nösslinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Okome"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Onsala"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Rolfstorp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ränneslöv"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Rävinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Sibbarp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Skrea"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Skummeslöv"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Skällinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Släp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Slättåkra"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Slöinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Snöstorp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Spannarp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Stafsinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Stamnared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Steninge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Stråvalla"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Svartrå"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Sällstorp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Södra Unnaryd"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Söndrum"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Tjärby"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Torpa"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Torup"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Träslöv"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Trönninge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Tvååker"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Tölö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Tönnersjö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ullared"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Valinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Vallda"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Vapnö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Varberg"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Veddige"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Veinge"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Vessige"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Vinberg"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Våxtorp"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Värö"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ysby"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Årstad"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ås"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Älvsåker"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Ölmevalla"
    },
    {
        "Länskod": "N",
        "Län": "Halland",
        "Församling": "Övraby"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": null
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Alanäs"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Alsen"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Aspås"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Berg"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Bodsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Bodum"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Borgvattnet"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Brunflo"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Bräcke"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Fjällsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Fors"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Frostviken"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Frösö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Föllinge"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Gillhov"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Gåxsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hackås"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hallen"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hammerdal"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hede"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hotagen"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hotagens lappförsamling"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Håsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Häggenås"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Hällesjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Kall"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Klövsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Kyrkås"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Laxsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Lillhärdal"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Linsell"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Lit"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ljusnedal"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Lockne"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Marby"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Marieby"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Mattmar"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Myssjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Mörsil"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Norderö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Nyhem"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Näs"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Näskott"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Offerdal"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Oviken"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ragunda"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Revsund"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Rätan"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Rödön"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Storsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ström"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Stugun"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Sundsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Sunne"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Sveg"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Tåsjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Tännäs"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Undersåker"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Undersåkers lappförs"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Vemdalen"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ytterhogdal"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Åre"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ås"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Åsarne"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Älvros"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Ängersjö"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Östersund"
    },
    {
        "Länskod": "Z",
        "Län": "Jämtland",
        "Församling": "Överhogdal"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Adelöv"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Almesåkra"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Alseda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Anderstorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Angerdshestra"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Askeryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bankeryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Barkeryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Barnarp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bellö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Björkö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bondstorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bosebo"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bottnaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bredaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bredestad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bringetofta"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Burseryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Byarum"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Båraryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bäckaby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bäckseda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Bälaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Dannäs"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Edshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Eksjö landsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Eksjö stadsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Femsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Flisby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Forserum"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Forsheda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Frinnaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Fryele"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Fröderyd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Gnosjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Gryteryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Gränna landsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Gränna stadsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Gällaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hagshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hakarp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Haurida"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hjälmseryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hjärtlanda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hultsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Huskvarna"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hylletofta"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hånger"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Hässleby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Höreda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ingatorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Järsnäs"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Järstorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Jönköpings Kristina"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Jönköpings Sofia"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Karlstorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Korsberga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Kråkshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Kulltorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Kållerstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Källeryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Kärda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Kävsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Lannaskede"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Lekeryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Lemnhult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Linderås"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ljungarum"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Lommaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Malmbäck"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Marbäck"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Mellby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Mulseryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Myresjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Månsarp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Norra Hestra"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Norra Ljunga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Norra Sandsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Norra Solberga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Norra Unnaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nydala"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nye"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Näsby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Näshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nässjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nässjö landsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nässjö stadsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Nävelsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ramkvilla"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Reftele"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Rogberga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Rydaholm"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Sandseryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Sandvik"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Skede"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Skepperstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Skirö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Skärstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Smålands artilleriregemente"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Stenberga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Stengårdshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Stockaryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Svarttorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Svenarum"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Säby"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Södra Hestra"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Södra Solberga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Tofteryd"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Torskinge"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Tånnö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Valdshult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Vallsjö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Vetlanda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Villstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Vireda"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Visingsö"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Voxtorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Vrigstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Våthult"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Värnamo"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Värnamo landsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Värnamo stadsförsamling"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Åker"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ås"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Åsenhöga"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ödestugu"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Öggestorp"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ökna"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Ölmstad"
    },
    {
        "Länskod": "F",
        "Län": "Jönköping",
        "Församling": "Öreryd"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Alböke"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Algutsboda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Algutsrum"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Arby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Blackstad"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Borgholm"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Bredsätra"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Bäckebo"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Böda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Dalhem"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Djursdala"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Döderhult"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Dörby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Egby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Fagerhult"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Fliseryd"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Frödinge"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Fågelfors"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Föra"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Förlösa"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gamleby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gladhammar"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Glömminge"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gräsgård"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gullabo"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gårdby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Gärdslösa"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hagby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hallingeberg"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Halltorp"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hjorted"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hossmo"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hulterstad"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Hälleberga"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Högby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Högsby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Högsrum"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Järeda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kalmar domkyrkoförsamling"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kalmar landsförsamling"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kalmar stadsförsamling"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Karlslunda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kastlösa"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kläckeberga"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kristdala"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kristvalla"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Kråksmåla"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Källa"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Köping"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ljungby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Locknevi"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Lofta"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Loftahammar"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Långasjö"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Långemåla"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Långlöt"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Lönneberga"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Löt"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Madesjö"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Misterhult"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Mortorp"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Målilla med Gårdveda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Möckleby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Mönsterås"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Mörbylånga"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Mörlunda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Norra Möckleby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Odensvi"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Oskar"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Oskarshamn"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Pelarne"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Persnäs"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Resmo"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Rumskulla"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Runsten"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ryssby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Räpplinge"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Sandby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Sankt Sigfrid"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Segerstad"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Smedby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Stenåsa"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Söderåkra"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Södra Möckleby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Södra Vi"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Torslunda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Torsås"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Tuna"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Tveta"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Törnsfall"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ukna"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vena"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ventlinge"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vickleby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vimmerby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vimmerby landsförsamling"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vimmerby stadsförsamling"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Virserum"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Vissefjärda"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Voxtorp"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Västervik"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Västra Ed"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Västrum"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Åby"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ålem"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Ås"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Örsjö"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Överum"
    },
    {
        "Länskod": "H",
        "Län": "Kalmar",
        "Församling": "Överums bruk"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Amsberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Aspeboda"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Avesta"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Bingsjö-Dådran"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Bjursås"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Boda"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Borlänge och Domnarves kbfd"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "By"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "By-Horndal"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Djura"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Enviken"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Evertsberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Falu Kristine"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Floda"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Folkärna"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Gagnef"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Garpenberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Grangärde"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Grytnäs"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Grängesberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Gustafs"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Hedemora landsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Hedemora stadsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Hosjö"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Husby"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Idre"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Järna"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Leksand"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Lima"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Ludvika"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Ludvika landsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Ludvika stadsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Malingsbo"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Malung"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Mockfjärd"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Mora"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Norns bruksförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Norrbärke"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Nås"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Ore"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Orsa"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Rättvik"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Siljansnäs"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Silvberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Skattunge"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Sollerön"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Stjärnsund"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Stora Kopparberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Stora Kopparberg"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Stora Skedvi"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Stora Tuna"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Sundborn"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Svartnäs"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Svärdsjö"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Säfsnäs"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Särna"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Säters landsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Säters stadsförsamling"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Söderbärke"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Torsång"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Transtrand"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Tyngsjö"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Venjan"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Vika"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Våmhus"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Ål"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Älvdalen"
    },
    {
        "Länskod": "W",
        "Län": "Kopparberg",
        "Församling": "Äppelbo"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Andrarum"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ausås"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Barkåkra"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Benestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Björnekulla"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Bollerup"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Bolshög"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Borrby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Brönnestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Brösarp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Båstad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Degeberga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Djurröd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Eljaröd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Emmislöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Everöd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Farstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Finja"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Fjälkestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Fjälkinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Fågeltofta"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Färingtofta"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Färlöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Förslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gladsax"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Glimåkra"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Grevie"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gryt"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gråmanstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gualöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gumlösa"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Gustav Adolf"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hammenhög"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hannas"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hjärnarp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hjärsås"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hov"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Huaröd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Häglinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hässleholm"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hästveda"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Höja"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hörja"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Hörröd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ignaberga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ivetofta"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ivö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Järrestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kiaby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Knislinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kristianstad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kristianstads garnisonsförsamling"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kristianstads stadsförsamling"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kverrestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kvidinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Kviinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Källna"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Köpinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Linderöd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Loshult"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Lyngsjö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Maglehem"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Matteröd"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Munka-Ljungby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Norra Mellby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Norra Sandby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Norra Strö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Norra Åkarp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Norra Åsum"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Nosaby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Nymö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Näsum"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Nävlinge"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Oderljunga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Onslunda"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Oppmanna"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Osby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Perstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ramsåsa"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ravlunda"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Rebbelberga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Rinkaby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Riseberga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Rya"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Röke"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Rörum"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Sankt Olof"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Simris"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Simrishamn"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Skepparslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Skånes-Fagerhult"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Smedstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Spjutstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Starby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Stiby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Stoby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Strövelstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Södra Mellby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Sörby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tomelilla"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Torekov"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tosterup"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tranås"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Trolle-Ljungby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tryde"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Träne"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tåssjö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Tåstarp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ullstorp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vallby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vankiva"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vedby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Verum"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vinslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Visseltofta"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vitaby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vittsjö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vittskövle"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vånga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Vä"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Västra Broby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Västra Karup"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Västra Sönnarslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Västra Torup"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Västra Vram"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Åhus"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ängelholm"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ängelholms garnisonsförsamling"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Ängelholms stadsförsamling"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Äsphult"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Önnestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Örkelljunga"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Örkened"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Össjö"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Österslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Broby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Herrestad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Hoby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Ingelstad"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Karup"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Ljungby"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Nöbbelöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Sönnarslöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Tommarp"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Vemmerlöv"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Östra Vram"
    },
    {
        "Länskod": "L",
        "Län": "Kristianstad",
        "Församling": "Övraby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Agunnaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Almundsryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Aneboda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Angelstad"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Annerstad"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Aringsås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Asa"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Berg"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Berga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Bergunda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Blädinge"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Bolmsö"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Drev"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Dädesjö"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Dänningelanda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Dörarp"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ekeberga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Furuby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Gårdsby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Göteryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hallaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hamneda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hemmesjö med Tegnaby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Herråkra"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hinneryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hjortsberga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hornaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Hovmantorp"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Härlunda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Härlöv"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Jät"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Kalvsvik"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Kvenneberga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Kånna"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Lekaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Lenhovda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Lidhult"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Linneryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ljuder"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ljungby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Markaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Mistelås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Moheda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Nottebäck"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Nöbbele"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Nöttja"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Odensjö"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ormesberga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Pjätteryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ryssby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Sjösås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Skatelöv"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Slätthög"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Stenbrohult"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Södra Ljunga"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Södra Sandsjö"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Söraby"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tannåker"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tingsås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tjureda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tolg"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Torpa"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Traryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tutaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Tävelsås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Urshult"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Uråsa"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Vederslöv"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Virestad"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Vislanda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Vittaryd"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Vrå"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Väckelsång"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Västra Torsås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Växjö"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Växjö landsförsamling"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Växjö stadsförsamling"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Åseda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Älghult"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Älmeboda"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Öja"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Öjaby-Härlöv"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Ör"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Östra Torsås"
    },
    {
        "Länskod": "G",
        "Län": "Kronoberg",
        "Församling": "Älmhult"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Allerum"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Anderslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Annelöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Arrie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ask"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Asmundtorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Baldringe"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Balkåkra"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bara"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Barsebäck"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Billeberga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Billinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bjuv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bjällerup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bjäresjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bjärshög"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Björka"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Blentarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bodarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bonderup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Borgeby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Borlunda"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Borrie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bosarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bosjökloster"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Brandstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bromma"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Brunnby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Brågarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bunkeflo"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Burlöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bårslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Börringe"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Bösarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Dagstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Dalby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Dalköpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ekeby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Esarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Eskilstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Everlöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Falsterbo"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Farhult"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Felestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fjelie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fjärestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Flackarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fleninge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Flädie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fosie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Frillestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fru Alstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fränninge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fuglie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Fulltofta"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Genarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gessie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gislöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Glemminge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Glostorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Glumslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Grönby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gudmuntorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gullarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gylle"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gårdstånga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gärdslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Gödelöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Görslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hallaröd"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Halmstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hammarlunda"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hammarlöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hardeberga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Harlösa"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hassle-Bösarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hedeskoga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Helsingborgs garnisonsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Helsingborgs landsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Helsingborgs stadsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hemmesdynge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hofterup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Holmby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hurva"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Husie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hyby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hyllie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Håslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Håstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hällestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Härslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hässlunda"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hög"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Höganäs"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Högestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Högseröd"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hököpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hörby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Hörup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Höör"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Igelösa"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ilstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ingelstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Jonstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Katslösa"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kattarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Knästorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Konga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kropp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kvistofta"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kyrkheddinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kyrkoköpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kågeröd"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Källs-Nöbbelöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Källstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Kävlinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lackalänga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Landskrona"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Landskrona garnisonsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lilla Beddinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lilla Harrie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lilla Isie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lilla Slågarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Limhamn"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lockarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lomma"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lunds domkyrkoförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lunds landsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lunds stadsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lyby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lyngby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Långaröd"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Löddeköpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Löderup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Lövestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Maglarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Malmö garnisonsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Malmö Karoli"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Malmö Sankt Johannes"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Malmö Sankt Pauli"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Malmö Sankt Petri"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Mellan-Grevie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Munkarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Mölleberga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Mörarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Nevishög"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Norra Nöbbelöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Norra Rörum"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Norra Skrävlinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Norra Vram"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Norrvidinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Odarslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ottarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Oxie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Raus"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Remmarlöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Reslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Revinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Risekatslösa"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Räng"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Röddinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Röstånga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sankt Ibb"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sankt Peters kloster"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Saxtorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Silvåkra"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Simlinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sireköpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sjörup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skabersjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skanör"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skarhult"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skeglinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skegrie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skivarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skurup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Skårby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Slimminge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Snårestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Solberga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stehag"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stenestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Hammar"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Harrie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Herrestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Köpinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Råby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stora Slågarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stångby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Stävie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Svalöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Svedala"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Svensköp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Svenstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Säby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Särslöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södervidinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Rörum"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Sallerup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Sandby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Åby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Åkarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Södra Åsum"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sövde"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Sövestad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tirup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tjörnarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tofta"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tolånga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Torrlösa"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tottarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Trelleborg"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Trelleborgs landsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Trollenäs"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tullstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Tygelsjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Törringe"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Uppåkra"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vadensjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Valleberga"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vallkärra"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vanstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Veberöd"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vellinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Viken"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Villie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Virke"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vollsjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Vomb"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Välinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Välluv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Väsby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västerstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Alstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Hoby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Ingelstad"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Karaby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Klagstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Kärrstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Nöbbelöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Sallerup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Skrävlinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Strö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Tommarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Vemmenhög"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Västra Vemmerlöv"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ystads garnisonsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ystads Sankt Petri"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ystads Sankta Maria"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Ystads stadsförsamling"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Äspinge"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Äspö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Öja"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Önnarp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Örsjö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Örtofta"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Grevie"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Karaby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Klagstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Kärrstorp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Sallerup"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Strö"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Torp"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östra Vemmenhög"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Östraby"
    },
    {
        "Länskod": "M",
        "Län": "Malmöhus",
        "Församling": "Öved"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Arjeplog"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Arvidsjaur"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Edefors"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Glommersträsk"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Gällivare"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Haparanda"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Hietaniemi"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Hortlax"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Jokkmokk"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Jukkasjärvi"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Junosuando"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Karesuando"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Karl Gustav"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Kiruna"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Korpilombolo"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Kvikkjokk"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Luleå domkyrkoförsamling"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Nederkalix"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Nederluleå"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Nedertorneå"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Norrfjärden"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Pajala"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Piteå landsförsamling"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Råneå"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Tärendö"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Vittangi"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Vitträsk"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Älvsby"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Överkalix"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Överluleå"
    },
    {
        "Länskod": "BD",
        "Län": "Norrbotten",
        "Församling": "Övertorneå"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Acklinga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Agnetorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Amnehärad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Baltak"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Barne-Åsaka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Beateberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Berg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Berga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Binneberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bitterna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bjurbäck"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bjurum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bjärby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bjärka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Björkäng"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Björsäter"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bolum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Borgunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Brandstorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bredsäter"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Brevik"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Brismene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Broby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Broddetorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Brunnhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bäck"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bällefors"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Bäreberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Böja"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Börstig"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Dala"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Daretorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Dimbo"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Edsvära"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Edåsa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Eggby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ek"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ekby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ekeskog"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Eling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Enåsa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Essunga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Falköpings landsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Falköpings stadsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Flakeberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Flistad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Flo"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Floby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Forsby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Forshem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fredsberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fridene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Friel"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Friggeråker"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Främmestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fröjered"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Frösve"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fullösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fyrunga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fåglum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Fägre"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Färed"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Gillstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Grevbäck"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Grolanda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Gudhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Gustav Adolf"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Gökhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Gösslunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Götene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Göteve"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Götlunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Habo"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hagelberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Halna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Halvås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hangelösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hassle"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hasslösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hjo landsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hjo stadsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hjälstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Holmestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Horn"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hornborga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hova"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hovby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Husaby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hyringa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Håkantorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Håle"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hångsdala"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Häggesled"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Häggum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hällestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hällum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Händene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Härja"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Härjevad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Härlunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Högstena"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Hömb"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Istrum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Jung"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Jäla"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Järpås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Karaby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Karleby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Karlsborg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kinne-Kleva"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kinneved"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kinne-Vedum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Korsberga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kungslena"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kvänum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kymbo"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kyrkefalla"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kyrkås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kållands-Åsaka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Källby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Kälvene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Larv"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Laske-Vedum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lavad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ledsjö"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Leksberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lekåsa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lerdala"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Levene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lidköping"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lindärva"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ljunghem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Locketorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Long"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lugnås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Luttra"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Lyrestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Låstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Längjum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Längnum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Malma"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mariestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Marka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Marum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Medelplana"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mellby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mo"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mofalla"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mularp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Mölltorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Naum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Fågelås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Härene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Kedum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Kyrketorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Lundby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Ving"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Vånga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Norra Åsarp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Nykyrka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Näs"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Odensåker"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Otterstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ottravad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ova"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Rackeby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ransberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ryd"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ryda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Råda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Rådene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sal"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Saleby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sandhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Segerstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sil"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sjogerstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skallmeja"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skalunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skara landsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skara stadsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skarstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skeby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skånings-Åsaka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skälvum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skärv"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skörstorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skövde landsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Skövde stadsförsamling"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Slädene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Slöta"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Smula"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Solberga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sparlösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Stenstorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Stenum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Strö"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sunnersberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Suntak"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sveneby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sventorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Synnerby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Särestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Säter"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sätuna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sävare"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Södra Fågelås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Södra Kedum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Södra Kyrketorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Södra Lundby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Södra Råda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Söne"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Sörby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tengene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tiarp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tidaholm"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tidavad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Timmersdala"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Torbjörntorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Torsö"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tranum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tråvad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Trässberg"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Trästena"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Trävattna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Trökörna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tun"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Tådene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Täng"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ugglum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ullene"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ullervad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Undenäs"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Utby"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Utvängstorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Uvered"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Valstad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Valtorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vara"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Varnhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Varola"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vartofta-Åsaka"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Varv"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Velinga"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vilske-Kleva"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vinköl"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vistorp"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Våmb"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vårkumla"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Väla"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Väring"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Värsås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Västerplana"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Västra Gerum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vättak"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Vättlösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Yllestad"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Ås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Åsle"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Älgarås"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Öglunda"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Önum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Örslösa"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Österbitterna"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Österplana"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Östra Gerum"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Östra Tunhem"
    },
    {
        "Länskod": "R",
        "Län": "Skaraborg",
        "Församling": "Öttum"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": null
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Adelsö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Adolf Fredrik"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Angarn"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Barnhusförsamlingen"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Björkö-Arholma"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Blidö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Boo"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Botkyrka"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Bro"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Bromma"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Brännkyrka"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Dalarö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Danderyd"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Danderyd/Djursholm"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Danderyd/Stocksund"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Danviks hospital och Sicklaö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Djurö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ed"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Edebo"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Edsbro"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ekerö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Engelbrekt"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Enhörna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Enskede"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Estuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Fasterna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Finska"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Fresta"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Frösunda"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Frötuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Fälttelegrafkåren"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Färentuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Gottröra"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Grödinge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Gustav Vasa"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Gustavsberg"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Göta Livgarde"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Haga"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Hammarby"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Hedvig Eleonora"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Hilleshög"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Hovförsamlingen"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Huddinge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Husby-Lyhundra"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Husby-Sjuhundra"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Husby-Ärlinghundra"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Håbo-Tibble"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Håtuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Häverö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Högalid"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Hölö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ingarö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Invalidkåren på Ulriksdal"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Jakob"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Jakob och Johannes"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Johannes"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Järfälla"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Katarina"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Klara"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Kungsholm"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Kårsta"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Lagga"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Lidingö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Livgardet till häst"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ljusterö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Lohärad"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Lovö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Lunda"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Låssa"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Länna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Malsta"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Maria Magdalena"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Markim"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Matteus"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Munsö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Muskö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Möja"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Mörkö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Nacka"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Norrsunda"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Norrtälje"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Norska jägarkåren"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Nynäshamn"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Nämdö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Närtuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Odensala"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Orkesta"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ornö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Oscar"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Riala"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Rimbo"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Roslags-Bro"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Roslags-Kulla"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Rådmansö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Rö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Salem"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sankt Göran"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sigtuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Singö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Skederid"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Skepptuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Skå"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Skånela"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sofia"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sollentuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Solna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sorunda"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Spånga"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Stockholm"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Stockholms-Näs"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Storkyrkoförsamlingen"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sundbyberg"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Svea trängkår"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Sånga"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Söderby-Karl"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Södertälje"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Södertälje landsförsamling"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Södertälje stadsförsamling"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Taxinge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Trångsund"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Turinge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Tveta"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Tyresö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Täby"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ununge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Utö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vada och Angarn"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vallentuna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vaxholm"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vidbo"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vårdinge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Väddö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Värmdö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Västerhaninge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Västra Ryd"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Vätö"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ytterenhörna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ytterjärna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Ösmo"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Össeby-Garn"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Österhaninge"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Österåker"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Östra Ryd"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Överenhörna"
    },
    {
        "Länskod": "A",
        "Län": "Stockholm",
        "Församling": "Överjärna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": null
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Aspö"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Barva"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Bergshammar"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Bettna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Björkvik"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Björnlunda"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Blacksta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Bogsta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Bälinge"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Bärbo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Dillnäs"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Dunker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Eskilstuna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Eskilstuna Fors"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Eskilstuna Fristaden"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Eskilstuna Kloster"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Eskilstuna Kloster och Fors"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Flen"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Floda"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Fogdö"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Forssa"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Frustuna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Gillberga"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Gryt"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Gåsinge"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Gåsinge-Dillnäs"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Halla"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Hammarby"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Helgarö"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Helgesta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Helgona"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Husby-Oppunda"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Husby-Rekarne"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Hyltinge"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Hällby"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Härad"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Julita"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Jäder"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Kattnäs"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Kila"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Kjula"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Kärnbo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lerbo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lid"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lilla Malma"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lilla Mellösa"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lista"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Ludgo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lunda"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Länna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Lästringe"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Mariefred-Kärnbo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Nykyrka"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Nyköpings Sankt Nicolai"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Nyköpings västra"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Nyköpings östra"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Näshulta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Ripsa"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Runtuna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Råby-Rekarne"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Råby-Rönö"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Sköldinge"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Spelvik"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Stenkvista"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Stigtomta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Stora Malm"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Strängnäs landsförsamling"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Strängnäs stadsförsamling"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Sundby"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Svärta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Sättersta"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Toresund"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Torshälla"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Torsåker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Trosa landsförsamling"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Trosa stadsförsamling"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Tumbo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Tuna"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Tunaberg"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Tystberga"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Vadsbro"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Vagnhärad"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Vallby"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Vrena"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Västerljung"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Västermo"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Västra Vingåker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Ytterselö"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Åker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Årdala"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Ärla"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Öja"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Österåker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Östra Vingåker"
    },
    {
        "Länskod": "D",
        "Län": "Södermanland",
        "Församling": "Överselö"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Almunge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Altuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Arnö"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Balingsta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Biskopskulla"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Björklinge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Bladåker"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Boglösa"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Bred"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Bälinge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Börje"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Börstil"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Dalby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Danmark"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Dannemora"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Ekeby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Enköping"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Enköpings-näs"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Faringe"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Film"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Fittja"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Forsmark"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Fröslunda"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Frösthult"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Funbo"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Gamla Uppsala"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Giresta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Gryta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Gräsö"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Hacksta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Hagby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Harg"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Helga Trefaldighet"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Hjälsta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Holm"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Husby-Långhundra"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Husby-Sjutolft"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Hållnäs"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Häggeby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Härkeberga"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Härnevi"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Hökhuvud"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Jumkil"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Järlåsa"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Knutby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Kulla"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Kungs-Husby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Källenäs"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Lena"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Lillkyrka"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Litslena"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Långtora"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Läby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Löt"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Morkarla"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Nysätra"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Ramsta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Rasbo"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Rasbokil"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Simtuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Skogs-Tibble"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Skokloster"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Skutskär"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Skuttunge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Skäfthammar"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Sparrsätra"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Stavby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Svinnegarn"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Söderfors"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Teda"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tegelsmora"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tensta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tierp"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tillinge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tolfta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Torstuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Torsvi"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Tuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Uppsala domkyrkoförsamling"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Uppsala-Näs"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vaksala"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vallby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Valö"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vassunda"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Veckholm"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vendel"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Viksta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Villberga"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vårfrukyrka"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Vänge"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Västeråker"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Västland"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Yttergran"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Åkerby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Åland"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Älvkarleby"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Ärentuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Öregrund"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Österby bruksförsamling"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Österlövsta"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Österunda"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Östhammar"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Östuna"
    },
    {
        "Länskod": "C",
        "Län": "Uppsala",
        "Församling": "Övergran"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Alster"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Arvika landsförsamling"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Arvika stadsförsamling"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Bjurtjärn"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Blomskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Boda"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Bogen"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Borgvik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Botilsäter"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Brattfors"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Bro"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Brunskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "By-Säffle"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Dalby"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ed"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Eda"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ekshärad"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Emigrantregistret"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Eskilsäter"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Filipstad"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Forshaga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Frykerud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Fryksände"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Färnebo"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Gillberga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Glava"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Grava"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Grums"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Gräsmark"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Gunnarskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Gustav Adolf"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Gåsborn"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Hagfors"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Hammarö"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Holmedal"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Huggenäs"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Högerud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Järnskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Karlanda"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Karlstads domkyrkoförsamling"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Karlstads landsförsamling"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Karlstads stadsförsamling"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Kila"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Kristinehamn"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Kroppa"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Köla"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Lekvattnet"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Lungsund"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Lysvik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Långserud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Mangskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Millesvik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Molkom"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Munkfors"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nedre Ullerud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nor"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nordmark"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Norra Finnskoga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Norra Ny"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Norra Råda"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Norrstrand"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ny"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nyed"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nyskoga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Nysund"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ransäter"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Rudskoga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Rämmen"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Segerstad"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Silbodal"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Sillerud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Skillingmark"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Stavnäs"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Stora Kil"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Storfors"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Sunne"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Sunnemo"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Svanskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Södra Finnskoga"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Södra Ny"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Trankil"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Tveta"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Töcksmark"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Varnum"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Visnum"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Visnums-Kil"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Vitsand"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Värmskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Väse"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Västra Fågelvik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Västra Ämtervik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Älgå"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Älvsbacka"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ölme"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Ölserud"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Östervallskog"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Östmark"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Östra Fågelvik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Östra Ämtervik"
    },
    {
        "Länskod": "S",
        "Län": "Värmland",
        "Församling": "Övre Ullerud"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Bjurholm"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Bureå"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Burträsk"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Bygdeå"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Byske"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Degerfors"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Dorotea"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Fredrika"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Holmsund"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Holmön"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Hörnefors"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Jörn"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Kalvträsk"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Lycksele"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Lövånger"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Malå"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Nordmaling"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Norsjö"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Nysätra"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Robertsfors"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Skellefteå landsförsamling"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Sorsele"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Stensele"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Sävar"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Tärna"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Umeå landsförsamling"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Umeå stadsförsamling"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Vilhelmina"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Vännäs"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Ytterstfors bruksförsamling"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Åsele"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Örträsk"
    },
    {
        "Länskod": "AC",
        "Län": "Västerbotten",
        "Församling": "Fällfors"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Alnö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Anundsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Arnäs"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Attmar"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Bjärtrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Björna"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Borgsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Boteå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Dal"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ed"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Edsele"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Galtströms bruksförsamling"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Gideå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Graninge"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Grundsunda"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Gudmundrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Gålsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Haverö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Helgum"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Hemsö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Holm"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Häggdånger"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Härnösand"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Hässjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Högsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Indal"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Junsele"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Lagfors bruksförsamling"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Liden"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ljustorp"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Långsele"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Lögdö bruksförsamling"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Mo"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Multrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Njurunda"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Nora"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Nordingrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Nätra"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ramsele"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Resele"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Selånger"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sidensjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Själevad"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Skog"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Skorped"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Skön"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Skönsmon"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sollefteå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Stigsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Styrnäs"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Stöde"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sundsvall"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sundsvalls Gustav Adolf"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sundsvalls mosaiska"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Svartvik"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sånga"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Säbrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Sättna"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Timrå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Torp"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Torsåker"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Trehörningsjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Tuna"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Tynderö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ullånger"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Vibyggerå"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Viksjö"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ytterlännäs"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Ådals-Liden"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Örnsköldsvik"
    },
    {
        "Länskod": "Y",
        "Län": "Västernorrland",
        "Församling": "Överlännäs"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Arboga landsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Arboga stadsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Berg"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Björksta"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Björskog"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Bro"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Dingtuna"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Enåker"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Fläckebo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Gunnilbo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Götlunda"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Haraker"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Harbo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Hed"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Himmeta"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Hubbo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Huddunge"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Irsta"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Karbenning"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kila"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kolbäck"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kumla"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kung Karl"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kungs-Barkarö"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kungsåra"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Kärrbo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Köpings landsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Köpings stadsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Lillhärad"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Malma"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Medåker"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Munktorp"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Möklinta"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Nora"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Norberg"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Norrby"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Odensvi"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Ramnäs"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Romfartuna"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Rytterne"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Sala landsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Sala stadsförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Sankt Ilian"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Sevalla"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Skerike"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Skinnskatteberg"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Skultuna"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Sura"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Surahammar"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Svedvi"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Säby"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Säterbo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Tillberga"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Torpa"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Tortuna"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Tärna"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Vittinge"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västanfors"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västerfärnebo"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västerlövsta"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västervåla"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västerås domkyrkoförsamling"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västerås-Barkarö"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Västra Skedvi"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Ängsö"
    },
    {
        "Länskod": "U",
        "Län": "Västmanland",
        "Församling": "Östervåla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": null
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Alboga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ale-Skövde"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Algutstorp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Alingsås landsförsamling"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Alingsås stadsförsamling"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ambjörnarp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Asklanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Berghem"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bergstena"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Billingsfors bruksförsamling"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Blidsberg"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bollebygd"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bolstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Borgstena"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Borås"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bredared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Broddarp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Brunn"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Brålanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bråttensby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Brämhult"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bäcke"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Bälinge"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Böne"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Dals-Ed"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Dalskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Dalstorp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Dalum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Dannike"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Edsleskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Eggvena"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Eriksberg"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Erikstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Erska"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Finnekumla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fivlered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fors"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fotskäl"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fristad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fritsla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Frändefors"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fröskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fullestad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fuxerna"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fänneslunda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Färgelanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Fölene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gestad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gesäter"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gingri"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Grinstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Grovare"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Grude"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Grönahög"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gullered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gunnarsnäs"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gällstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Gärdhem"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hajom"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hemsjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Herrljunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hillared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hjärtum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hol"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Holm"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Holsljunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Horla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Horred"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hov"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hudene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hulared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Humla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hyssna"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Håbol"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Håcksvik"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hålanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hällstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Härna"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Högsäter"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Hössna"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Istorp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Jällby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Järbo"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Järn"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kalv"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kattunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kilanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kinna"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kinnarumma"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Knätte"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kullings-Skövde"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kvinnestad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Källunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kärråkra"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kölaby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Kölingared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Lagmansered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Landa"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Laxarby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Lena"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Lerdal"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Lerum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Liared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ljungsarp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ljur"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ljushult"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Långared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Länghem"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Magra"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Marbäck"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Mjäldrunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Mjöbäck"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Mo"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Molla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Mossebo"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Murum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Månstad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Mårdaklev"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Möne"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Naglum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Nittorp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Norra Björke"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Norra Säm"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Norska Skogsbygden"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Nårunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Nödinge"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Nössemark"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Od"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ornunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Redslared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Remmene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Revesjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Roasjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Rommele"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Råggärd"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Rångedala"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Rännelanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Rödene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Rölanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sandhult"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sankt Peder"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Seglora"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sexdrega"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Siene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sjötofta"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skallsjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skephult"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skepplanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skållerud"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skölvene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Skövde"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Solberga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Starrkärr"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Steneby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Stora Lundby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Stora Mellby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Strängsered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sundals-Ryr"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Surteby-Kattunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Svenljunga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Sätila"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Björke"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Härene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Säm"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Ving"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Vånga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Södra Åsarp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tarsled"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Timmele"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tisselskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Toarp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Torestorp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Torp"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Torpa"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Torrskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tostared"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tranemo"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Trollhättan"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tumberg"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tunge"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tvärred"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tämta"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tärby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Töftedal"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Töllsjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Tösse med Tydje"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ullasjö"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ulricehamn"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Upphärad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Varnum"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vassända"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vesene"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vist"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vårvik"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vänersborg"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vänersnäs"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Väne-Ryr"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Väne-Åsaka"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Vänga"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Västerlanda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Västra Tunhem"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Åmåls landsförsamling"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Åmåls stadsförsamling"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ånimskog"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Åsbräcka"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Älekulla"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Älvsered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ärtemark"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Äspered"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ödeborg"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ödenäs"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ödskölt"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ölsremma"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Ör"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Öra"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Örby"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Örsås"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Östad"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Östra Frölunda"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Öxabäck"
    },
    {
        "Länskod": "P",
        "Län": "Älvsborg",
        "Församling": "Öxnevalla"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Almby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Asker"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Askersunds landsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Askersunds stadsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Axberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Bo"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Degerfors"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Edsberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ekeby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Eker"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ervalla"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Fellingsbro"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Finnerödja"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Glanshammar"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Grythyttan"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Gräve"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Guldsmedshyttan"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Gällersta"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hackvad"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hallsberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hammar"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hardemo"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hidinge"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hjulsjö"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hovsta"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hällefors"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Hörken"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Järnboås"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Karlsdal"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Karlskoga"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Kil"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Knista"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Kräcklinge"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Kumla"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Kvistbro"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lerbäck"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lillkyrka"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lindesberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lindesbergs landsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lindesbergs stadsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ljusnarsberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Längbro"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Lännäs"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Mosjö"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Nora bergsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Nora stadsförsamling"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Norrbyås"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Nysund"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Näsby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ramsberg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ramundeboda"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Rinkaby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Skagershult"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Sköllersta"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Snavlunda"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Stora Mellösa"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Svennevad"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Tived"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Tysslinge"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Tångeråsa"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Täby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Vedevåg"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Viby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Viker"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Vintrosa"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ånsta"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Ödeby"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Örebro"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Örebro Nikolai"
    },
    {
        "Länskod": "T",
        "Län": "Örebro",
        "Församling": "Örebro Olaus Petri"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Allhelgona"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Appuna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Asby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ask"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Askeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Askeryd/Västra Ryd"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Bankekind"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Bjälbo"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Björkeberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Björsäter"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Blåvik"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Brunneby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Börrum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Dagsberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Drothem"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ekeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ekebyborna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Fivelstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Flistad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Fornåsa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Furingstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gammalkil"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gistad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Godegård"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Grebo"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gryt"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gusum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gårdeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Gärdserum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hagebyhöga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hannäs"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Harstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Heda"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Herrberga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Herrestad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hogstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Horn"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hov"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hycklinge"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hägerstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Hällestad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Häradshammar"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Högby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Jonsberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Järstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kaga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kimstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kisa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Klockrike"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Konungsund"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kristberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Krokek"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kuddby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kullerstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kumla"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kvarsebo"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kvillinge"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Källstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kärna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Kättilstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Landeryd"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ledberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Lillkyrka"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Linköpings domkyrkoförsamling"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Linköpings Sankt Lars"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ljung"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Lönsås"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Malexander"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Mjölby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Mogata"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Motala"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Motala landsförsamling"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Motala stadsförsamling"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Normlösa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norra Vi"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norrköpings Borg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norrköpings Hedvig"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norrköpings Matteus"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norrköpings Sankt Johannes"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Norrköpings Sankt Olai"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Nykil"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Nässja"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Oppeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Orlunda"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rappestad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Regna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ringarum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rinna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Risinge"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rogslösa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rystad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rök"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Rönö"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Sankt Anna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Sankt Per"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Simonstorp"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Sjögestad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skeda"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skedevi"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skeppsås"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skällvik"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skänninge"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skärkind"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Skönberga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Slaka"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Stjärnorp"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Stora Åby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Strå"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Styrstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Sund"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Svanshals"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Svinhult"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Sya"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Söderköping"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tidersrum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tingstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tjällmo"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tjärstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Torpa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Trehörna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tryserum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Tåby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Törnevalla"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ulrika"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vadstena"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Valdemarsvik"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vallerstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Varv och Styra"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Veta"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Viby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vikingstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vinnerstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vist"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vreta kloster"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vånga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vårdnäs"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Vårdsberg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Väderstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Värna"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västerlösa"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Eneby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Harg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Husby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Ny"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Ryd"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Skrukeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Stenby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Västra Tollstad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Väversunda"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Yxnerum"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Å"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Åsbo"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Åtvid"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Älvestad"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Ödeshög"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Örberga"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Örtomta"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Ed"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Eneby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Harg"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Husby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Ny"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Ryd"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Skrukeby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Stenby"
    },
    {
        "Länskod": "E",
        "Län": "Östergötland",
        "Församling": "Östra Tollstad"
    }
]
', true);

        $result = [];
        foreach ($arr as $key => $value) {
            $result[$value['Länskod'] . $value['Län']]['code']          = $value['Länskod'];
            $result[$value['Länskod'] . $value['Län']]['county']          = $value['Län'];
            $result[$value['Länskod'] . $value['Län']]['parish'][] = $value['Församling'];
//            $result['county'][]          = $value['Län'];
        }
//        dd(array_values($result));

        return array_values($result);

    }

    private function getGender(): array
    {
        return [
            'M' => 'Man',
            'K' => 'Kvinna'
        ];
    }
}
