<?php

namespace App\Http\Controllers;

use App\Exports\POExport;
use App\Mail\ExampleMail;
use App\Mail\sendMail;
use App\Models\emailHistory;
use App\Models\Hazmat;
use App\Models\MakeModel;
use App\Models\poOrder;
use App\Models\poOrderItem;
use App\Models\PoOrderItemsHazmats;
use App\Models\Ship;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class POOrderController extends Controller
{
    //
    public function add($ship_id, $po_order_id = null)
    {
        $data = array('name' => "Our Code World");
        // Path or name to the blade template to be rendered
        $template_path = 'email.example';



        // Mail::send(['text'=> $template_path ], $data, function($message) {
        //     // Set the receiver and subject of the mail.
        //     $message->to('krishna.patel628@gmail.com', 'krishna')->subject('Laravel First Mail');
        //     // Set the sender
        //     $message->from('shopify@meetanshi.email','Our Code World');
        // });
        if (@$po_order_id) {
            $head_title = "View";
        } else {
            $head_title = "Add";
        }
        $backurl = "ship/view" . "/" . $ship_id . "#po-records";
        $poData = poOrder::with('poOrderItems')->find($po_order_id);

        return view('ships.po.add', compact('head_title', 'ship_id', 'poData', 'backurl'));
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
    public function viewReleventItem($poiteam_id)
    {
        $poItem = poOrderItem::with(['poOrder:id,po_no', 'poOrderItemsHazmets.hazmat.equipment','poOrderItemsHazmets.emailHistory'])->find($poiteam_id);
       
        $backurl = 'ships/po-order/add/' . $poItem['ship_id'] . "/" . $poItem['po_order_id'];
        $table_type = Hazmat::select('table_type')->distinct()->pluck('table_type');
        $hazmats = [];
        $hazmatIds = $poItem->poOrderItemsHazmets->pluck('hazmat_id')->toArray();

        foreach ($table_type as $type) {
            $hazmats[$type] = Hazmat::where('table_type', $type)->get(['id', 'name', 'table_type']);
        }
        return view('ships.po.releventItem', compact('poItem', 'backurl', 'hazmats', 'hazmatIds'));
    }
    public function import(Request $request)
    {
        $ship_id  = $request->input('ship_id');

        $file = $request->file('excel_file');
        $data = Excel::toArray([], $file);

        $errors = []; // Array to collect errors

        if (!empty($data) && count($data) > 0) {
            $headers = array_shift($data[0]); // Get headers
            foreach ($data[0] as $rowIndex => $row) { // Assuming data is on the first sheet
                $rowWithHeaders = array_combine($headers, $row);
                $rowErrors = [];

                $requiredFields = ['PO NO', 'PO Date'];



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
                $po_no = (string)$rowWithHeaders['PO NO'];
                $insert = [
                    'po_no' =>  $po_no,
                    'ship_id' => $ship_id,
                    'po_date' => Carbon::createFromFormat('d/m/Y', $rowWithHeaders['PO Date'])->format('Y-m-d'), // Date format
                    'machinery' => $rowWithHeaders['Machinery'],
                    'make_model' => $rowWithHeaders['Make Model'],
                    'supplier_name' => $rowWithHeaders['Supplier Name'],
                    'address' => $rowWithHeaders['Supplier Address'],
                    'contact_person' => $rowWithHeaders['Supplier Contact Person'],
                    'phone' => $rowWithHeaders['Supplier Phone Number'],
                    'email' => $rowWithHeaders['Supplier Email'],
                    'onboard_reciving_date' => Carbon::createFromFormat('d/m/Y', $rowWithHeaders['Onboard reciving date'])->format('Y-m-d'),
                    'delivery_location' => $rowWithHeaders['Delivery Location']
                ];

                if (!$poorder) {
                    // Insert if PO doesn't exist
                    $poinsert = poOrder::create($insert);
                    $po_id = $poinsert->id;
                } else {
                    // Update if PO exists
                    $poinsert = poOrder::where('po_no', '=', (string) $po_no)->update($insert);
                    $po_id = $poorder->id; // Existing record ID
                }

                // Check for existing PO items
                $poItemsCheck = poOrderItem::where('po_order_id', $po_id)
                    ->where('ship_id', $ship_id)
                    ->where('description', $rowWithHeaders['Description'])
                    ->first();

                $orderItems = [
                    'ship_id' => $ship_id,
                    'po_order_id' => $po_id,
                    'description' => $rowWithHeaders['Description'],
                    'part_no' => $rowWithHeaders['Part No'],
                    'qty' => $rowWithHeaders['Qty'],
                    'unit' => $rowWithHeaders['Unit'],
                    'impa_no' => $rowWithHeaders['IMPA NO.(if available)'],
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
    public function poItemsHazmatSave(Request $request)
    {
        $post = $request->input();
        if (@$post['hazmats']) {
            $supplier_emaill = poOrder::find($post['po_order_id'])->email;
            $ships = Ship::with('client.userDetail')->find($post['ship_id']);
            $client_email = $ships->client->userDetail->email;
            $accounting_team_email = $ships->client->accounting_team_email;
            $email_history_arry = [
                'suppliear_email' =>  $supplier_emaill,
                'company_email' =>  $client_email,
                'accounting_email' =>  $accounting_team_email,
                'ship_id' =>  $post['ship_id'],
                'po_order_item_id' => $post['po_order_item_id'],
                'po_order_id' => $post['po_order_id'],
                'is_sent_email' => 0
            ];
            foreach ($post['hazmats'] as $key => $value) {
                if (@$value['isInstalled'] == 'no') {
                    $value['isIHMUpdated'] = 'no';
                }
                $value['ship_id'] = $post['ship_id'];
                $value['po_order_id'] = $post['po_order_id'];
                $value['po_order_item_id'] = $post['po_order_item_id'];
                $value['hazmat_id'] = $key;
                $getModel = MakeModel::find($value['modelMakePart']);
                $value['doc1'] = @$getModel['document1']['name'] ?? '';
                $value['doc2'] = @$getModel['document2']['name'] ?? '';
                $sloats = [];

                $poOrderItemHazmat =  PoOrderItemsHazmats::updateOrCreate(['id' => $value['id']], $value);
                $email_history_arry['po_order_item_hazmat_id'] = $poOrderItemHazmat->id;
                if($value['isRecivedDoc'] == 'yes'){
                    emailHistory::where('po_order_item_hazmat_id',$poOrderItemHazmat->id)->where('is_sent_email',0)->delete();
                }
                if($poOrderItemHazmat->wasRecentlyCreated){
                    if ($value['hazmat_type'] == 'Unknown') {
                        // Example Usage
                        $startDate = date('Y-m-d');  // Starting date (today's date)
                        $daysToAdd = 1;
                        $newDate = $this->addDaysToCurrentDate($startDate, $daysToAdd);
                        $email_history_arry['start_date'] =    $newDate;
                        emailHistory::create($email_history_arry);

                        for ($i = 0; $i <= 3; $i++) {
                            $daysToAdd = 3;
                            $newDate = $this->addDaysToCurrentDate($newDate, $daysToAdd);
                            $email_history_arry['start_date'] =    $newDate;
                            emailHistory::create($email_history_arry);
                        }
                    }
                }
               
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'save successfully']);
    }

    function addDaysToCurrentDate($startDate, $daysToAdd)
    {
        $newDate = strtotime("+$daysToAdd days", strtotime($startDate)); // Add days to start date
        return date('Y-m-d', $newDate); // Format the new date
    }

    public function getEquipMent($hazmat_id)
    {
        try {
            $hazmat = Hazmat::with('equipment:id,hazmat_id,equipment')->find($hazmat_id);
            $groupedEquipment = $hazmat->equipment->groupBy('equipment');
            return response()->json(['isStatus' => true, 'message' => 'Equipment retrieved successfully.', 'equipments' => $groupedEquipment]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getManufacturer($hazmat_id, $type)
    {
        try {
            $manufacturers = MakeModel::where('hazmat_id', $hazmat_id)->where('equipment', $type)->select('manufacturer')->distinct()->get();
            return response()->json(['isStatus' => true, 'message' => 'Equipment besed manufacturers retrieved successfully.', 'manufacturers' => $manufacturers]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getmodel($hazmat_id, $equipment, $manufacturer)
    {
        try {
            $documentData = MakeModel::where('hazmat_id', $hazmat_id)->where('equipment', $equipment)->where('manufacturer', $manufacturer)->get();

            $data = $documentData->map(function ($document) {
                $document->modelmakepart = "{$document->model}-{$document->make}-{$document->part}";
                return $document;
            });

            return response()->json(['isStatus' => true, 'message' => 'Manufacturers besed document data retrieved successfully.', 'documentData' => $data]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function getPartBasedDocumentFile($hazmat_id)
    {
        try {
            $documentFile = MakeModel::select('id', 'document1', 'document2')->find($hazmat_id);

            return response()->json(['isStatus' => true, 'message' => 'Part besed document file retrieved successfully.', 'documentFile' => $documentFile]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function sendMail(Request $request)
    {
        $data = $request->input();
        $shipsData = Ship::find($data['shipId']);
        $clientCompany = User::select('email')->find($shipsData['client_user_id']);
        $shipmail = User::select('email')->find($shipsData['user_id']);
        $supplier_email = poOrder::select('email')->find($data['order_id']);
        $mailData = ['title' => $data['email_subject'], 'body' => $data['email_body']];
        Mail::to($clientCompany['email'])
            ->cc([$shipmail['email'], $supplier_email['email']])
            ->queue(new sendMail($mailData));
        return response()->json(['isStatus' => true, 'message' => 'sent email successfully.']);
    }
    public function poOrderSample()
    {
        return Excel::download(new  POExport, 'sample.xlsx');
    }
}
