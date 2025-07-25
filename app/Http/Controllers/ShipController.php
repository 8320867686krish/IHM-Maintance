<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image as Image;
use App\Http\Requests\ShipRequest;
use App\Jobs\sendUserRegisterMail;
use App\Models\Brifing;
use App\Models\CheckHazmat;
use App\Models\ClientCompany;
use App\Models\configration;
use App\Models\DesignatedPersionShip;
use App\Models\DesignatedPerson;
use App\Models\Exam;
use App\Models\Hazmat;
use App\Models\Majorrepair;
use App\Models\MakeModel;
use App\Models\partManuel;
use App\Models\poOrder;
use App\Models\PoOrderItemsHazmats;
use App\Models\PreviousAttachment;
use App\Models\Ship;
use App\Models\ShipTeams;
use App\Models\Summary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Traits\ImageUpload;
use  App\Traits\ShipData;
use Illuminate\Support\Facades\DB;

class ShipController extends Controller
{
    //
    use ImageUpload, ShipData;

    public function index(request $request)
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;

        if ($currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $ships = $user->ships->load('client');
        } else {
            $shipsQuery = Ship::with('client', 'hazmatComapny');
            if ($request->has('search')) {
                $search = $request->search;
                $shipsQuery->where(function ($query) use ($search) {
                    $query->where('ship_name', 'like', '%' . $search . '%')
                        ->orWhere('imo_number', 'like', '%' . $search . '%');
                });
            }
            $shipsQuery->when($currentUserRoleLevel == 2, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
            });

            $shipsQuery->when($currentUserRoleLevel == 5, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('client_user_id', $user['id']);
            });

            $shipsQuery->when($currentUserRoleLevel == 6, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('user_id', $user['id']);
            });
            $ships = $shipsQuery->paginate(8);
            if ($request->has('search')) {
                $ships->appends(['search' => $request->search]);
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'ships_html' => view('components.ships-list', compact('ships'))->render(),
            ]);
        }

        // Return the view with the ships data
        return view('ships.list', compact('ships'));
    }
    public function create()
    {

        $role_level = Auth::user()->roles->first()->level;
        $user =  Auth::user();
        $hazmat_companies_id  = $user['hazmat_companies_id'];
        $clientsQuery = ClientCompany::query();
        $clientsQuery->when($role_level == 2, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
        });

        $clientsQuery->when($role_level == 5, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                ->where('client_user_id', $user->id);
        });
        $experts = User::whereHas('roles', function ($query) use ($user) {
            $query->where('level', 4)->orderBy('level', 'asc');
        })->when($user->roles->first()->level != 1, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user->hazmat_companies_id);
        })->get(['id', 'name']);

        $managers = User::whereHas('roles', function ($query) use ($user) {
            $query->where('level', 3)->orderBy('level', 'asc');
        })->when($user->roles->first()->level != 1, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user->hazmat_companies_id);
        })->get(['id', 'name']);

        $clientsQuery->when($role_level == 6, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                ->where('user_id', $user->id);
        });

        $clients = $clientsQuery->orderBy('id', 'desc')->get(['id', 'name', 'manager_initials']);
        return view('ships.add', ['head_title' => 'Add', 'button' => 'Save', 'clients' => $clients, 'hazmat_companies_id' => $hazmat_companies_id, 'managers' => $managers, 'experts' => $experts]);
    }
    public function store(ShipRequest $request)
    {
        try {
            DB::beginTransaction(); // Start a transaction

            $id = $request->input('id');
            $inputData = $request->input();
            if (@$inputData['client_company_id']) {
                $client_user = ClientCompany::where('id', $inputData['client_company_id'])->select('user_id', 'hazmat_companies_id')->first();
                $userdata = [
                    'name' =>   $inputData['ship_name'],
                    'email' =>   $inputData['email'],
                    'phone' =>   $inputData['phone'],
                    'password' => $inputData['password'],
                    'hazmat_companies_id' => $client_user['hazmat_companies_id']
                ];
            }

            if ($id == 0) {
                $user = User::create($userdata);
                $role_id = Role::where('level', 6)->pluck('id')->first();
                $user->assignRole([$role_id]);
                $inputData['user_id'] = $user->id;
            } else {
                if (@$inputData['user_id']) {
                    if (@!$userdata['password']) {
                        unset($userdata['password']);
                    }
                    User::updateOrCreate(['id' => $inputData['user_id']], $userdata);
                }
            }

            if (@$client_user) {
                $inputData['client_user_id'] = $client_user['user_id'];
                $inputData['hazmat_companies_id'] = $client_user['hazmat_companies_id'];
            }

            if ($request->hasFile('ship_image')) {
                if ($inputData['id'] != 0) {
                    $shipData = Ship::find($inputData['id']);
                    if ($shipData && $shipData->ship_image) {
                        $oldImagePath = $this->deleteImage('uploads/ship/', $shipData->ship_image);
                       
                    }
                     if ($shipData && $shipData->orignal_image) {
                         $orignalImage = $this->deleteImage('uploads/ship/orignal/', $shipData->orignal_image);
                     }
                }
                $imageFile = $request->file('ship_image');
                $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
               


                $targetSize = 372;
                list($width, $height) = getimagesize($imageFile);
                $extension = strtolower($imageFile->getClientOriginalExtension());

                switch ($extension) {
                    case 'jpeg':
                    case 'jpg':
                        $source = imagecreatefromjpeg($imageFile);
                        break;
                    case 'png':
                        $source = imagecreatefrompng($imageFile);
                        break;
                    case 'gif':
                        $source = imagecreatefromgif($imageFile);
                        break;
                    default:
                        throw new \Exception("Unsupported image type.");
                }
                if ($width >= $height) {
                    $new_width = $targetSize;
                    $new_height = ($height * $targetSize) / $width;
                } else {
                    $new_height = $targetSize;
                    $new_width = ($width * $targetSize) / $height;
                }

                $resized = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($resized, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $square = imagecreatetruecolor($targetSize, $targetSize);
                $white = imagecolorallocate($square, 255, 255, 255);
                imagefill($square, 0, 0, $white);
                $x = ($targetSize - $new_width) / 2;
                $y = ($targetSize - $new_height) / 2;
                imagecopy($square, $resized, $x, $y, 0, 0, $new_width, $new_height);
                $path = public_path('uploads/ship/' . $imageName);
                imagejpeg($square, $path, 90); // change to imagepng or imagegif if needed
                imagedestroy($source);
                imagedestroy($resized);
                imagedestroy($square);
                $inputData['ship_image'] = $imageName;
                $originalName = $this->upload($request, 'ship_image', 'uploads/ship/orignal');
                $inputData['orignal_image'] = $originalName;
            }

            $ship = Ship::updateOrCreate(['id' => $id], $inputData);
            if ($id == 0) {
                $inputData['ship_id'] = $ship->id;
            } else {
                $inputData['ship_id'] = $id;
            }

            if (@$inputData['maneger_id'] || @$inputData['expert_id']) {
                ShipTeams::where('ship_id', $inputData['ship_id'])->delete();
                if (@$inputData['maneger_id']) {
                    foreach ($inputData['maneger_id'] as $user_id) {
                        ShipTeams::create([
                            'user_id' => $user_id,
                            'ship_id' => $inputData['ship_id'],
                            'hazmat_companies_id' => $inputData['hazmat_companies_id']
                        ]);
                    }
                }

                if (@$inputData['expert_id']) {
                    foreach ($inputData['expert_id'] as $user_id) {

                        ShipTeams::create([
                            'user_id' => $user_id,
                            'ship_id' => $inputData['ship_id'],
                            'hazmat_companies_id' => $inputData['hazmat_companies_id']
                        ]);
                    }
                }
            }
            DB::commit(); // Commit the transaction
            $message = empty($id) ? "Ship added successfully" : "Ship updated successfully";
            if ($id == 0) {
                $userMailData = [
                    'name' => $inputData['ship_name'],
                    'email' => $inputData['email'],
                    'password' => $inputData['password'],
                ];
                try {
                    dispatch(new sendUserRegisterMail($userMailData));
                    return response()->json(['isStatus' => true, 'message' => $message]);
                } catch (\Exception $e) {
                    return response()->json(['isStatus' => false, 'message' => 'User created successfully, but failed to send welcome email']);
                }
            }


            return response()->json(['isStatus' => true, 'message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack(); // Rollback the transaction on error

            print_r($th->getMessage());
            exit();
            //  return back()->withError($th->getMessage())->withInput();
        }
    }

    public function portalGuide()
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $configration = configration::first();
        if ($currentUserRoleLevel == 2 ||   $currentUserRoleLevel == 3 ||   $currentUserRoleLevel == 4) {
            $showurl = $configration['hazmat_company'] ?? null
                ? asset('uploads/configration/' . $configration['hazmat_company'])
                : null;
        } else if ($currentUserRoleLevel == 5) {
            $showurl = $configration['client_company'] ?? null
                ? asset('uploads/configration/' . $configration['client_company'])
                : null;
        } else if ($currentUserRoleLevel == 6) {
            $showurl = $configration['ship_staff'] ?? null
                ? asset('uploads/configration/' . $configration['ship_staff'])
                : null;
        } else {
            $showurl = '';
        }
        return view('helpCenter.pdfview', compact('showurl', 'configration'));
    }
    public function destroy(string $id)
    {
        try {
            $ship = Ship::findOrFail($id);
            $userdelete = User::findOrFail($ship['user_id']);
            $userdelete->delete();
            $ship->delete();
            $user = Auth::user();
            $currentUserRoleLevel = $user->roles->first()->level;

            if ($currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
                $ships = $user->ships->load('client');
            } else {

                $shipsQuery = Ship::with('client', 'hazmatComapny');

                $shipsQuery->when($currentUserRoleLevel == 2, function ($query) use ($user) {
                    return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
                });

                $shipsQuery->when($currentUserRoleLevel == 5, function ($query) use ($user) {
                    return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                        ->where('client_user_id', $user['id']);
                });

                $shipsQuery->when($currentUserRoleLevel == 6, function ($query) use ($user) {
                    return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                        ->where('user_id', $user['id']);
                });

                // Execute the query and get the ships
                $ships = $shipsQuery->paginate(8);
            }
            return response()->json([
                'isStatus' => true,
                'message' => 'Ship deleted successfully',
                'ships_html' => view('components.ships-list', compact('ships'))->render()
            ]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function shipView($ship_id)
    {
        $ship = Ship::with(['shipTeams', 'client', 'hazmatComapny'])->findOrFail($ship_id);

        Session::put(['ship_id' => $ship_id]);
        $isBack = 0;
        if (session('back') == 1) {
            $isBack = 1;
        }
        Session::forget('back');
        $user =  Auth::user();


        $shipId = $ship_id;

        $poOrders = poOrder::withCount(['poOrderItems'])->where('ship_id', $ship_id)->OrderBy('id', 'desc')->get();

        $users = $ship->shipTeams->pluck('user_id')->toArray();
        if (!Gate::allows('ships.add')) {
            $readonly = "readonly";
        } else {
            $readonly = "";
        }

        $experts = User::whereHas('roles', function ($query) use ($user) {
            $query->where('level', 4)->orderBy('level', 'asc');
        })->when($user->roles->first()->level != 1, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user->hazmat_companies_id);
        })->get(['id', 'name']);

        $managers = User::whereHas('roles', function ($query) use ($user) {
            $query->where('level', 3)->orderBy('level', 'asc');
        })->when($user->roles->first()->level != 1, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user->hazmat_companies_id);
        })->get(['id', 'name']);

        $hazmat_companies_id = $ship->hazmat_companies_id;
        $partMenual = partManuel::where('ship_id', $ship_id)->get();
        $summary = Summary::where('ship_id', $ship_id)->get();

        $checkHazmatIHMPart = CheckHazmat::with(relations: 'hazmat')->where('ship_id', $ship_id)->get();


        $trainingRecoreds = DesignatedPersionShip::with('designatedPersonDetail')
            ->whereHas('designatedPersonDetail', function ($query) use ($ship_id) {
                $query->where('ship_id', $ship_id);
            })
            ->get();


        // Separate results in PHP
        $designatedPerson = $trainingRecoreds->filter(function ($record) {
            return $record->designatedPersonDetail->position !== 'SuperDp';
        });
        $dpsore = $trainingRecoreds->filter(function ($record) {
            return $record->designatedPersonDetail->position === 'SuperDp';
        });
        $trainingRecoredHistory = Exam::where('ship_id', $ship_id)->orderBy('id', 'desc')->get();


        $mdnoresults = MakeModel::select([
            'make_models.id',
            'make_models.md_date',
            'make_models.md_no',
            'make_models.coumpany_name',
            DB::raw('GROUP_CONCAT(DISTINCT hazmats.short_name ORDER BY hazmats.short_name ASC) AS hazmat_names')
        ])
            ->join('po_order_items_hazmats', 'po_order_items_hazmats.model_make_part_id', '=', 'make_models.id')
            ->join('hazmats', 'hazmats.id', '=', 'po_order_items_hazmats.hazmat_id')
            ->where('po_order_items_hazmats.ship_id', $ship_id)
            ->whereNotNull('po_order_items_hazmats.doc1')
            ->groupBy('make_models.id', 'make_models.md_date', 'make_models.md_no', 'make_models.coumpany_name')
            ->get();


        $sdocresults = MakeModel::select([
            'make_models.id',
            'make_models.sdoc_date',
            'make_models.sdoc_no',
            'make_models.issuer_name',
            'make_models.sdoc_objects',
            DB::raw('GROUP_CONCAT(DISTINCT hazmats.short_name ORDER BY hazmats.short_name ASC) AS hazmat_names')
        ])
            ->join('po_order_items_hazmats', 'po_order_items_hazmats.model_make_part_id', '=', 'make_models.id')
            ->join('hazmats', 'hazmats.id', '=', 'po_order_items_hazmats.hazmat_id')
            ->where('po_order_items_hazmats.ship_id', $ship_id)
            ->whereNotNull('po_order_items_hazmats.doc2')
            ->groupBy('make_models.id', 'make_models.sdoc_date', 'make_models.sdoc_no', 'make_models.issuer_name', 'make_models.sdoc_objects')
            ->get();

        $ships = Ship::get();
        $majorrepair = Majorrepair::where('ship_id', operator: $ship_id)->orderBy('id', 'desc')->get();

        $previousAttachment = PreviousAttachment::where('ship_id', operator: $ship_id)->orderBy('date_from', 'desc')->get();

        $brifingHistory = Brifing::with('DesignatedPersonDetail')->where('ship_id', operator: $ship_id)->get();

        return view('ships.view', compact('experts', 'managers', 'isBack', 'ship', 'readonly', 'users', 'poOrders', 'ship_id', 'checkHazmatIHMPart', 'hazmat_companies_id', 'partMenual', 'summary', 'trainingRecoreds', 'mdnoresults', 'dpsore', 'trainingRecoredHistory', 'ships', 'majorrepair', 'brifingHistory', 'designatedPerson', 'sdocresults', 'previousAttachment', 'designatedPerson'));
    }

    public function assignShip(Request $request)
    {

        $inputData = $request->input();
        $inputData['id'] = $inputData['ship_id'];

        ShipTeams::where('ship_id', $inputData['ship_id'])->delete();

        if (@$inputData['maneger_id']) {
            foreach ($inputData['maneger_id'] as $user_id) {
                ShipTeams::create([
                    'user_id' => $user_id,
                    'ship_id' => $inputData['ship_id'],
                    'hazmat_companies_id' => $inputData['hazmat_companies_id']
                ]);
            }
        }

        if (@$inputData['expert_id']) {
            foreach ($inputData['expert_id'] as $user_id) {

                ShipTeams::create([
                    'user_id' => $user_id,
                    'ship_id' => $inputData['ship_id'],
                    'hazmat_companies_id' => $inputData['hazmat_companies_id']
                ]);
            }
        }
        return response()->json(['isStatus' => true, 'message' => 'Ship assign successfully!!']);
    }
}
