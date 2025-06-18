<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class POExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $data = [
            ['1111', '30/10/2024', 'Marine Supplies Ltd', 'test', 'test', 'test','test','982524981','test@gmail.com','13/11/2024','test','test','imp111','pa111','5','kg']
        
        ];

        array_unshift($data, [
    'PO NO', 
    'PO Date (dd/mm/yyyy)', 
    'Machinery', 
    'Make Model', 
    'Supplier Name', 
    'Supplier Address',
    'Supplier Contact Person',
    'Supplier Phone Number',
    'Supplier Email',
    'Onboard Receiving Date (dd/mm/yyyy)', 
    'Delivery Location',
    'Description',
    'IMPA NO.(if available)',
    'Part No',
    'Qty',
    'Unit'
]);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fill data
foreach ($data as $rowIndex => $row) {
    foreach ($row as $colIndex => $value) {
        $sheet->setCellValueByColumnAndRow($colIndex + 1, $rowIndex + 1, $value);
    }
}

// Optional: Add note to the date columns
$sheet->getComment('B1')->getText()->createTextRun("Please enter date in dd/mm/yyyy format (e.g., 30/10/2024)");
$sheet->getComment('J1')->getText()->createTextRun("Please enter date in dd/mm/yyyy format (e.g., 13/11/2024)");

$writer = new Xlsx($spreadsheet);
$writer->save('sample-po-template.xlsx');
    }
}
