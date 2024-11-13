<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class POExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $data = [
            ['1111', '30/10/2024', 'Marine Supplies Ltd', 'test', 'test', 'test','test','982524981','test@gmail.com','13/11/2024','test','test','imp111','pa111','kg','5','Relevant']
        
        ];

        // Add headers as the first row of data
        array_unshift($data, ['PO NO', 'PO Date', 'Machinery', 'Make Model', 'Supplier Name', 'Supplier Address','Supplier Contact Person','Supplier Phone Number','Supplier Email','Onboard reciving date','Delivery Location','Description','IMPA NO.(if available)','Part No','Qty','Unit','Type']);

        // Return the collection
        return collect($data);
    }
}
