<?php

namespace App\Exports;

use App\Models\DenmarkEmigration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DenmarkEmigrationsExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DenmarkEmigration::select('id', 'user_id','organization_id','first_name','last_name','sex','age','birth_place','last_resident','profession','destination_city',
            'destination_country','ship_name','traveled_on','contract_number','comment','secrecy','travel_type',
            'source','dduid')->get();
    }

    public function headings(): array
    {
        return [
           'id', 'user_id','organization_id','first_name','last_name','sex','age','birth_place','last_resident','profession','destination_city',
            'destination_country','ship_name','traveled_on','contract_number','comment','secrecy','travel_type',
            'source','dduid'
        ];
    }
}
