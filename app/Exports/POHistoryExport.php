<?php
namespace App\Exports;

use App\Models\poOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class POHistoryExport implements FromCollection, WithHeadings
{
    protected $shipId;

    public function __construct($shipId)
    {
        $this->shipId = $shipId;
    }
    public function collection()
    {
        return PoOrder::with('poOrderItems')
        ->where('ship_id', $this->shipId)
        ->get()->flatMap(function ($po) {
            return $po->poOrderItems->map(function ($item) use ($po) {
                return [
                    $po->po_no,
                    $po->po_date,
                    $po->machinery,
                    $po->make_model,
                    $po->supplier_name,
                    $po->address,
                    $po->contact_person,
                    $po->phone,
                    $po->email,
                    $po->onboard_reciving_date,
                    $po->delivery_location,
                    $item->description,
                    $item->impa_no ?? '',
                    $item->part_no,
                    $item->qty,
                    $item->unit,
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'PO NO',
            'PO Date',
            'Machinery',
            'Make Model',
            'Supplier Name',
            'Supplier Address',
            'Supplier Contact Person',
            'Supplier Phone Number',
            'Supplier Email',
            'Onboard Receiving Date',
            'Delivery Location',
            'Description',
            'IMPA NO.(if available)',
            'Part No',
            'Qty',
            'Unit'
        ];
    }
}
?>