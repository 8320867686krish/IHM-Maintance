<?php

namespace App\Exports;

use App\Models\poOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class POHistoryExport implements FromCollection, WithHeadings
{
       protected $shipId, $fromDate, $toDate, $tillToday;


   public function __construct($shipId, $fromDate, $toDate, $tillToday)
    {
        $this->shipId = $shipId;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->tillToday = $tillToday;
    }
    public function collection()
    {
       return PoOrder::with('poOrderItems')
    ->where('ship_id', $this->shipId)
    ->when($this->fromDate && $this->toDate && $this->tillToday == 0, function ($query) {
        $query->whereBetween('po_date', [$this->fromDate, $this->toDate]);
    })
    ->get()
    ->flatMap(function ($po) {
        return $po->poOrderItems->map(function ($item) use ($po) {
            return [
                $po->po_no,
                $po->po_date,
                $po->machinery,
                $po->make_model,
                $item->description,
                $item->impa_no ?? '',
                $item->part_no,
                $item->qty,
                $item->unit,
                $po->supplier_name,
                $po->address,
                $po->contact_person,
                $po->phone,
                $po->email,
                $po->onboard_reciving_date,
                $po->delivery_location,
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
            'Description',
            'IMPA NO.(if available)',
            'Part No',
            'Qty',
            'Unit',
            'Supplier Name',
            'Supplier Address',
            'Supplier Contact Person',
            'Supplier Phone Number',
            'Supplier Email',
            'Onboard Receiving Date',
            'Delivery Location',

        ];
    }
}
