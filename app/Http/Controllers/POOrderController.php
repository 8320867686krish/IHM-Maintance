<?php

namespace App\Http\Controllers;

use App\Models\Hazmat;
use App\Models\poOrder;
use App\Models\poOrderItem;
use App\Models\PoOrderItemsHazmats;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class POOrderController extends Controller
{
    //
    public function add($ship_id, $po_order_id = null)
    {
        if (@$po_order_id) {
            $head_title = "View";
        } else {
            $head_title = "Add";
        }
        $backurl = "ship/view" . "/" . $ship_id . "#po-records";
        $poData = poOrder::with('poOrderItems')->find($po_order_id);
        $table_type = Hazmat::select('table_type')->distinct()->pluck('table_type');

        $hazmats = [];

        foreach ($table_type as $type) {
            $hazmats[$type] = Hazmat::where('table_type', $type)->get(['id', 'name', 'table_type']);
        }
        return view('ships.po.add', compact('head_title', 'ship_id', 'poData', 'backurl','hazmats'));
    }

    public function store(Request $request)
    {
        $post = $request->input();

        $post = $request->except('_token');
        $order_item = $post;
        unset($order_item['items']);
        $poorderResult = poOrder::where('po_no', $post['po_no'])->where('ship_id', $post['ship_id'])->first();
        if ($post['po_id']) {
            $poOrder = poOrder::updateOrCreate(['id' => $post['po_id']], $order_item);
        } else {
            if (!@$poorderResult) {
                $poOrder = poOrder::create($order_item);
            }
        }

        if (@$post['deleted_id']) {
            $deletedIds = explode(',', $post['deleted_id']); // This splits the string into an array
            poOrderItem::whereIn('id', $deletedIds)->delete();
        }
        if (@$post['items']) {
            foreach ($post['items'] as $key => $value) {
                $value['ship_id'] = $post['ship_id'];
                $value['po_order_id'] = $poOrder->id;
                poOrderItem::updateOrCreate(['id' => $key], $value);
            }
        }

        return response()->json(['isStatus' => true, 'message' => 'Po Order save successfully']);
    }

    public function import(Request $request)
    {
        $ship_id  = $request->input('ship_id');

        $file = $request->file('excel_file');
        $data = Excel::toArray([], $file);

        $errors = []; // Array to collect errors

        if (!empty($data) && count($data) > 0) {
            $headers = array_shift($data[0]); // Get headers
            foreach ($data[0] as $rowIndex =>$row) { // Assuming data is on the first sheet
                $rowWithHeaders = array_combine($headers, $row);
                $rowErrors = []; 
                
                $requiredFields = ['PO NO', 'Request NO', 'Vessel NO', 'Machinery', 'Make Model', 'Supplier Name', 'Contact Person', 'Phone Number', 'Email', 'Address', 'Item Description', 'Item Part No', 'Item Qty', 'Item Unite Price', 'Item Amount','Type'];

                foreach ($requiredFields as $field) {

                    if (empty($rowWithHeaders[$field])) {
                        $rowErrors[] = "Row " . ($rowIndex + 2) . ": {$field} is required."; // +2 to account for header and 0-based index

                    }
                }

                // If there are errors, continue to the next row
                if (!empty($rowErrors)) {
                    $errors = array_merge($errors, $rowErrors);
                    continue; 
                }
                // Check if PO order exists
                $poorder = poOrder::where('po_no', $rowWithHeaders['PO NO'])
                    ->where('ship_id', $ship_id)
                    ->first();

                // Prepare data for insertion
                $insert = [
                    'po_no' => $rowWithHeaders['PO NO'],
                    'ship_id' => $ship_id,
                    'request_number' => $rowWithHeaders['Request NO'],
                    'vessel_no' => $rowWithHeaders['Vessel NO'],
                    'machinery' => $rowWithHeaders['Machinery'],
                    'make_model' => $rowWithHeaders['Make Model'],
                    'supplier_name' => $rowWithHeaders['Supplier Name'],
                    'contact_person' => $rowWithHeaders['Contact Person'],
                    'phone' => $rowWithHeaders['Phone Number'],
                    'email' => $rowWithHeaders['Email'],
                    'address' => $rowWithHeaders['Address']
                ];

                if (!$poorder) {
                    $poinsert = poOrder::create($insert);
                    $po_id = $poinsert->id;
                } else {
                    $poinsert = poOrder::where('po_no', $rowWithHeaders['PO NO'])->update($insert);
                    $po_id = $poorder->id; // Use object instead of array
                }

                // Check for existing PO items
                $poItemsCheck = poOrderItem::where('po_order_id', $po_id)
                    ->where('ship_id', $ship_id)
                    ->where('description', $rowWithHeaders['Item Description'])
                    ->first();

                $orderItems = [
                    'ship_id' => $ship_id,
                    'po_order_id' => $po_id,
                    'description' => $rowWithHeaders['Item Description'],
                    'part_no' => $rowWithHeaders['Item Part No'],
                    'qty' => $rowWithHeaders['Item Qty'],
                    'unit_price' => $rowWithHeaders['Item Unite Price'],
                    'amount' => $rowWithHeaders['Item Amount'],
                    'type_category' => $rowWithHeaders['Type']
                ];

                if ($poItemsCheck) {
                    poOrderItem::where('id', $poItemsCheck->id)->update($orderItems);
                } else {
                    poOrderItem::create($orderItems);
                }
            }

            // If there are errors, return them to the user
            if (!empty($errors)) {

                return redirect()->to(url("/ship/view/{$ship_id}#po-records"))->withErrors($errors)->withInput();
            }
        }

        return redirect()->to(url("/ship/view/{$ship_id}#po-records"))->with('success', 'Record inserted successfully');
    }
    public function poDelete($po_id)
    {
        poOrder::where('id', $po_id)->delete();
        return response()->json(['isStatus' => true, 'message' => 'Po Order Delete successfully']);
    }
    public function poItemsHazmatSave(Request $request){
       $post = $request->input();
       if(@$post['hazmats']){
       
        foreach ($post['hazmats'] as $key => $hazmat) {
            print_r($hazmat[$key]);
            if (isset($hazmat['table_type'])) {
                $tableType = $hazmat['table_type']; // Accessing table type
                echo $tableType; // Print the table type
            } else {
                echo "Row $key: table_type is not set."; // Handle the missing key
            }
            // Do tableType with $key and $tableType
        }
            foreach($post['hazmats'] as $key=>$value){
               
                // $hazmats = [
                //     'ship_id ' => $post['shipId'],
                //     'po_order_id' => $post['po_order_id'],
                //     'po_order_item_id' => $post['id'],
                //     'hazmat_id' => $key,
                //     'hazmat_type' => $value['table_type']
                // ];
            }
          //  PoOrderItemsHazmats::create($hazmats);
       }
       return response()->json(['isStatus' => true, 'message' => 'save successfully']);

    }
}
