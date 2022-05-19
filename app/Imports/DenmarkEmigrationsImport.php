<?php

namespace App\Imports;

use App\Models\DenmarkEmigration;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
//use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Validators\ValidationException;

class DenmarkEmigrationsImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return Model|null
    */
//    public function model(array $row)
//    {
//        return new DenmarkEmigration([
//            //
//
//        ]);
//    }

    public function collection(Collection $rows)
    {

        try {
            foreach ($rows as $row) {
                DenmarkEmigration::create([
                    'organization_id' => 2,
                    'user_id' => auth()->user()->id,
                    'archive_id' => 1,
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'sex' => $row['sex'],
                    'age' => $row['age'],
                    'birth_place' => $row['birth_place'],
                    'last_resident' => $row['last_resident'],
                    'profession' => $row['profession'],
                    'destination_city' => $row['destination_city'],
                    'destination_country' => $row['destination_country'],
                    'ship_name' => $row['ship_name'],
                    'traveled_on' => $row['traveled_on'],
                    'contract_number' => $row['contract_number'],
                    'comment' => $row['comment'],
                    'secrecy' => $row['secrecy'],
                    'travel_type' => $row['travel_type'],
                    'source' => $row['source'],
                    'dduid' => $row['dduid']
                ]);
            }

        } catch (ValidationException $e) {

            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failures->row(); // row that went wrong
            }
        }
    }


}
