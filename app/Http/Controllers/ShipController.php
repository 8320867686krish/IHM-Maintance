<?php

namespace App\Http\Controllers;

use App\Models\ClientCompany;
use App\Models\Ship;
use App\Models\ShipTeams;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;
use App\Traits\ImageUpload;

class ShipController extends Controller
{
    //
    use ImageUpload;

    public function index($client_id = null)
    {
        $user = Auth::user();

        $currentUserRoleLevel = $user->roles->first()->level;

        // Initialize the query for ships
        if ($currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $ships = $user->ships->load('client');
        } else {
            // Otherwise, start with a query builder
            $shipsQuery = Ship::with('client');

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
            $ships = $shipsQuery->get();
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
    public function store(Request $request)
    {
        try {

            $id = $request->input('id');
            $inputData = $request->input();
            if (@$inputData['client_id']) {
                $client_user = ClientCompany::where('id', $inputData['client_id'])->select('user_id', 'hazmat_companies_id')->first();
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
                        $oldImagePath = $this->deleteImage('uploads/ship/', $shipData->logo);
                    }
                }
                $image = $this->upload($request, 'ship_image', 'uploads/ship');
                $inputData['ship_image'] = $image;
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
           
            $message = empty($id) ? "Ship added successfully" : "Ship updated successfully";
            return response()->json(['isStatus' => true, 'message' => $message]);

        } catch (\Throwable $th) {
            print_r($th->getMessage());
          //  return back()->withError($th->getMessage())->withInput();
        }
    }


    public function destroy(string $id)
    {
        try {
            $ship = Ship::findOrFail($id);
            $user = User::findOrFail($ship['user_id']);
            $user->delete();
            $ship->delete();
            return response()->json(['isStatus' => true, 'message' => 'Ship deleted successfully']);

        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function shipView($ship_id)
    {
        $isBack = 0;
        if (session('back') == 1) {
            $isBack = 1;
        }
        Session::forget('back');

        $user =  Auth::user();

        $experts =   User::whereHas('roles', function ($query) {
            $query->where('level', 4)->orderBy('level', 'asc');
        })->where('hazmat_companies_id', $user->hazmat_companies_id)->get(['id', 'name']);

        $managers =  User::whereHas('roles', function ($query) {
            $query->where('level', 3)->orderBy('level', 'asc');
        })->where('hazmat_companies_id', $user->hazmat_companies_id)->get(['id', 'name']);
        $ship = Ship::with(['shipTeams', 'client'])->find($ship_id);

        $users = $ship->shipTeams->pluck('user_id')->toArray();
        if (!Gate::allows('projects.edit')) {
            $readonly = "readOnly";
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

        return view('ships.view', compact('experts', 'managers', 'isBack', 'ship', 'readonly', 'users'));
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
