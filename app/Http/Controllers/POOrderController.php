<?php

namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

use App\Exports\POExport;
use App\Http\Requests\POrderRequest;
use App\Jobs\SendReminderMailJob;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Throwable;

class POOrderController extends Controller
{
    //
    public function add($ship_id, $po_order_id = null)
    {
        $ship = Ship::with('client:id,name')->find($ship_id);
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $client_name = $ship['client']['name'];
        if (@$po_order_id) {
            $head_title = "View";
        } else {
            $head_title = "Add";
        }
        $backurl = "ship/view" . "/" . $ship_id . "#po-records";
        $poData = poOrder::with('poOrderItems', 'emailHistory')->find($po_order_id);
        $filteredEmailHistory = ($poData?->emailHistory ?? collect())->filter(function ($history) {
            return $history->history_type === 'ship';
        });
        $filteredEmailHVendoristory = ($poData?->emailHistory ?? collect())->filter(function ($history) {
            return $history->history_type === 'vendor';
        });
       

        return view('ships.po.add', compact('head_title', 'ship_id', 'poData', 'backurl', 'client_name', 'currentUserRoleLevel', 'filteredEmailHVendoristory', 'filteredEmailHistory'));
    }

    public function store(POrderRequest $request)
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
                poOrderItem::updateOrCreate(['id' => $key, 'po_order_id' => $poOrder->id], $value);
            }
        }
        $url = url('ships/po-order/add/' . $post['ship_id'] . "/" . $poOrder->id);
        return response()->json(['isStatus' => true, 'message' => 'Po Order save successfully', 'url' => $url]);
    }
    public function viewReleventItem($poiteam_id)
    {
        $user = Auth::user();
        $poItem = poOrderItem::with(['poOrder:id,po_no', 'poOrderItemsHazmets.hazmat', 'poOrderItemsHazmets.makeModel', 'poOrderItemsHazmets'])->find($poiteam_id);
        $currentUserRoleLevel = $user->roles->first()->level;

        $equipmentsQuery = MakeModel::selectRaw('MIN(id) as id, equipment')
            ->groupBy('equipment');

        if ($currentUserRoleLevel != 1) {
            $equipmentsQuery->where('hazmat_companies_id', $user->hazmat_companies_id);
        }
        $equipments = $equipmentsQuery->get();

        $backurl = 'ships/po-order/add/' . $poItem['ship_id'] . "/" . $poItem['po_order_id'];
        $table_type = Hazmat::select('table_type')->distinct()->pluck('table_type');
        $hazmats = [];
        $hazmatIds = $poItem->poOrderItemsHazmets->pluck('hazmat_id')->toArray();

        foreach ($table_type as $type) {
            $hazmats[$type] = Hazmat::where('table_type', $type)->get(['id', 'name', 'table_type']);
        }
        return view('ships.po.releventItem', compact('poItem', 'backurl', 'hazmats', 'hazmatIds', 'equipments'));
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
                if (!empty($rowErrors)) {
                    $errors = array_merge($errors, $rowErrors);
                    continue;
                }
                $po_no = (string)$rowWithHeaders['PO NO'];
                $poorder = poOrder::where('po_no', $rowWithHeaders['PO NO'])
                    ->where('ship_id', $ship_id)
                    ->first();
                $insert = [
                    'po_no' => (string)($rowWithHeaders['PO NO'] ?? ''),
                    'ship_id' => $ship_id,
                    'po_date' => !empty($rowWithHeaders['PO Date']) ? $this->parseExcelDate($rowWithHeaders['PO Date']) : '',
                    'machinery' => $rowWithHeaders['Machinery'] ?? '',
                    'make_model' => $rowWithHeaders['Make Model'] ?? '',
                    'supplier_name' => $rowWithHeaders['Supplier Name'] ?? '',
                    'address' => $rowWithHeaders['Supplier Address'] ?? '',
                    'contact_person' => $rowWithHeaders['Supplier Contact Person'] ?? '',
                    'phone' => $rowWithHeaders['Supplier Phone Number'] ?? '',
                    'email' => $rowWithHeaders['Supplier Email'] ?? '',
                    'onboard_reciving_date' => !empty($rowWithHeaders['Onboard Receiving Date']) ? $this->parseExcelDate($rowWithHeaders['Onboard Receiving Date']) : '',
                    'delivery_location' => $rowWithHeaders['Delivery Location'] ?? '',
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
                    'impa_no' => $rowWithHeaders['IMPA NO.(if available)']
                ];

                if ($poItemsCheck) {
                    poOrderItem::where('id', $poItemsCheck->id)->where('po_order_id', $po_id)->update($orderItems);
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
    function parseExcelDate($date)
    {
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'm/d/Y']; // Add more if needed

        foreach ($formats as $format) {
            try {
                $dt = Carbon::createFromFormat($format, $date);
                if ($dt !== false) {
                    return $dt->format('Y-m-d');
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null; // Or throw an exception if you prefer
    }
    public function poDelete($po_id)
    {
        poOrder::where('id', $po_id)->delete();
        $ship_id = Session::get('ship_id');
        $poOrders = poOrder::withCount(['poOrderItems'])->where('ship_id', $ship_id)->OrderBy('id', 'desc')->get();
        $html = view('components.po-order-item', compact('poOrders'))->render();
        return response()->json(['isStatus' => true, 'message' => 'Po Order Delete successfully', 'html' => $html]);
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
            ];
            if (@$post['suspected_hazmat_remove']) {
                $deletedIds = explode(',', $post['suspected_hazmat_remove']); // This splits the string into an array
                PoOrderItemsHazmats::whereIn('hazmat_id', $deletedIds)->where('po_order_item_id', $post['po_order_item_id'])->delete();
            }
            if (@$post['suspected_hazmat']) {
                foreach ($post['hazmats'] as $key => $value) {


                    if (@$value['isInstalled'] == 'no') {
                        $value['isIHMUpdated'] = 'no';
                    }
                    $value['ship_id'] = $post['ship_id'];
                    $value['po_order_id'] = $post['po_order_id'];
                    $value['po_order_item_id'] = $post['po_order_item_id'];
                    $value['hazmat_id'] = $key;
                    $PoOrderItemsHazmat = PoOrderItemsHazmats::find($value['id']);
                    $value['model_make_part_id'] = @$value['model_make_part_id'] ?? @$PoOrderItemsHazmat['model_make_part_id'];
                    $value['doc1'] = @$value['doc1'] ?  $value['model_make_part_id'] . 'M' : '';
                    $value['doc2'] = @$value['doc2'] ?  $value['model_make_part_id'] . 'S' : '';
                    $sloats = [];

                    $poOrderItemHazmat =  PoOrderItemsHazmats::updateOrCreate(['id' => $value['id']], $value);
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
            $user = Auth::user();
            $currentUserRoleLevel = $user->roles->first()->level;

            $equipmentsQuery = MakeModel::selectRaw('MIN(id) as id, equipment')
                ->groupBy('equipment');

            if ($currentUserRoleLevel != 1) {
                $equipmentsQuery->where('hazmat_companies_id', $user->hazmat_companies_id);
            }

            $equipments = $equipmentsQuery->get();

            return response()->json(['isStatus' => true, 'message' => 'Equipment retrieved successfully.', 'equipments' => $equipments]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getManufacturer($hazmat_id, $type)
    {
        try {
            $manufacturers = MakeModel::where('equipment', $type)->select('manufacturer')->distinct()->get();
            return response()->json(['isStatus' => true, 'message' => 'Equipment besed manufacturers retrieved successfully.', 'manufacturers' => $manufacturers]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function getmodel($hazmat_id, $equipment, $manufacturer)
    {
        try {
            $documentData = MakeModel::where('equipment', $equipment)->where('manufacturer', $manufacturer)->get();

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
            $documentFile = MakeModel::select('id', 'md_no', 'sdoc_no')->find($hazmat_id);

            return response()->json(['isStatus' => true, 'message' => 'Part besed document file retrieved successfully.', 'documentFile' => $documentFile]);
        } catch (Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
    public function sendMail(Request $request)
    {
        $data = $request->input();
        $shipsData = Ship::with(['client.userDetail', 'hazmatComapny:id,email,name', 'shipStaff:id,email'])->find($data['shipId']);
        $accounting_team_email = $shipsData['client']['accounting_team_email'];
        $client_company_email = $shipsData['client']['userDetail']['email'];
        $shipstaff_email = $shipsData['shipStaff']['email'];

        $from_email = $shipsData['hazmatComapny']['email'];
        $vendor = poOrder::select('email')->find($data['order_id']);
        $to = $vendor['email'];

        $from = [
            'email' => $from_email,
            'name' => $shipsData['hazmatComapny']['name']
        ];
        $attachments = [];
        if ($request->hasFile('attachments.*')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments');
                $fullPath = storage_path('app/' . $path);
                $attachments[] = $fullPath;
            }
        }
        $email_history_arry = [
            'suppliear_email' =>  $to,
            'company_email' =>  $client_company_email,
            'accounting_email' =>  $accounting_team_email,
            'from_email' => $from_email,
            'ship_id' =>  $data['shipId'],
            'po_order_id' => $data['order_id'],
        ];
        if (!@$data['history_type']) {
            $email_history_arry['history_type'] = 'ship';
            $email_history_arry['shipstaff_email'] =  $shipstaff_email;
        } else {
            $email_history_arry['history_type'] = $data['history_type'];
        }

        emailHistory::create($email_history_arry);
        $mailData = ['title' => $data['email_subject'], 'body' => $data['email_body'], 'attachments' => $attachments];
        $ccEmails = [$client_company_email, $accounting_team_email];
        if (!empty($data['history_type'])) {
            $ccEmails[] = $shipstaff_email;
        }
        Mail::to($to)
            ->cc($ccEmails)
            ->queue(new sendMail($mailData, $from));
        return response()->json(['isStatus' => true, 'message' => 'sent email successfully.']);
    }
    public function recivedDoc(Request $request)
    {
        $post = $request->input();
        $poorder = poOrder::where('id', $post['recived_order_id'])->update([
            'isRecivedDoc' => 1,
            'recived_document_comment' => $post['recived_document_comment'],
            'recived_document_date' => $post['recived_document_date']
        ]);
        return response()->json(['isStatus' => true, 'message' => 'save successfully.']);
    }
    public function poOrderSample()
    {
        $data = [
            ['1111', '30/10/2024', 'Marine Supplies Ltd', 'test', 'test', 'test', 'test', '982524981', 'test@gmail.com', '13/11/2024', 'test', 'test', 'imp111', 'pa111', '5', 'kg']
        ];

        array_unshift($data, [
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
        ]);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $value) {
                $columnLetter = Coordinate::stringFromColumnIndex($colIndex + 1); // e.g., A, B, C...
                $cell = $columnLetter . ($rowIndex + 1); // e.g., A1, B2...
                $sheet->setCellValue($cell, $value);
            }
        }

        // Add comments
        $sheet->getComment('B1')->getText()->createTextRun("Please enter date in dd/mm/yyyy format (30/10/2024) ");
        $sheet->getComment('J1')->getText()->createTextRun("Please enter date in dd/mm/yyyy format (13/11/2024) ");

        // Output directly to browser
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'sample-po-template.xlsx';

        // Set headers for download
        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
