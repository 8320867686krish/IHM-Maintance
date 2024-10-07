<?php

namespace App\Http\Controllers;

use App\Models\ClientCompany;
use App\Models\Ship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ShipController extends Controller
{
    //
    public function index($client_id = null)
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        // Initialize the query for ships
        $shipsQuery = Ship::query();

        // Apply conditions based on the role level
        $shipsQuery->when($currentUserRoleLevel == 2, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
        });

        $shipsQuery->when($currentUserRoleLevel == 5, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
            ->where('client_user_id',$user['id']);
        });

        $shipsQuery->when($currentUserRoleLevel == 6, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                ->where('user_id',$user['id']);
        });

        $ships = $shipsQuery->get();
        return view('ships.list', compact('ships'));
    }
    public function create()
    {
        $role_level = Auth::user()->roles->first()->level;
        $user =  Auth::user();
        $hazmat_companies_id  = $user['hazmat_companies_id'];
        $clientsQuery = ClientCompany::query();

        $clientsQuery->when($role_level == 2, function ($query) use ($user) {
            // For role level 2, filter by hazmat company ID
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
        });

        $clientsQuery->when($role_level == 5, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                ->where('client_user_id', $user->id);
        });

        $clientsQuery->when($role_level == 6, function ($query) use ($user) {
            return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                ->where('user_id', $user->id);
        });

        $clients = $clientsQuery->orderBy('id', 'desc')->get(['id', 'name', 'manager_initials']);
        return view('ships.add', ['head_title' => 'Add', 'button' => 'Save', 'clients' => $clients, 'hazmat_companies_id' => $hazmat_companies_id]);
    }
    public function store(Request $request)
    {
        try {
            $id = $request->input('id');
            $inputData = $request->input();
            $client_user = ClientCompany::where('id',$inputData['client_id'])->select('user_id','hazmat_companies_id')->first();
            $userdata = [
                'name' =>   $inputData['ship_name'],
                'email' =>   $inputData['email'],
                'phone' =>   $inputData['phone'],
                'password' => $inputData['password'],
                'hazmat_companies_id' => $client_user['hazmat_companies_id']
            ];
            if ($id == 0) {
                $user = User::create($userdata);
                $role_id = Role::where('level', 6)->pluck('id')->first();
                $user->assignRole([$role_id]);
                $inputData['user_id'] = $user->id;
            }else{
                if(@!$userdata['password']){
                    unset($userdata['password']);
                }
                User::updateOrCreate(['id' => $inputData['user_id']],$userdata);
            }

            $inputData['client_user_id'] = $client_user['user_id'];
            $inputData['hazmat_companies_id'] = $client_user['hazmat_companies_id'];
            Ship::updateOrCreate(['id' => $id], $inputData);
            $message = empty($id) ? "Ship added successfully" : "Ship updated successfully";

            return redirect('ships')->with('message', $message);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        try {
            $clientsQuery = ClientCompany::query();
            $role_level = Auth::user()->roles->first()->level;
            $user =  Auth::user();
            $clientsQuery->when($role_level == 2, function ($query) use ($user) {
                // For role level 2, filter by hazmat company ID
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id']);
            });
    
            $clientsQuery->when($role_level == 5, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('client_user_id', $user->id);
            });
    
            $clientsQuery->when($role_level == 6, function ($query) use ($user) {
                return $query->where('hazmat_companies_id', $user['hazmat_companies_id'])
                    ->where('user_id', $user->id);
            });
    
            $clients = $clientsQuery->orderBy('id', 'desc')->get(['id', 'name', 'manager_initials']);
            $ship = Ship::find($id);
            $shipUser = User::find( $ship['user_id']);
            return view('ships.add', ['head_title' => 'Edit', 'button' => 'Update', 'clients' => $clients, 'ship' => $ship,'shipUser'=>$shipUser]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function destroy(string $id)
    {
        try {
            $ship = Ship::findOrFail($id);
            $user = User::findOrFail( $ship['user_id']);
            $user->delete();
            $ship->delete();
            return redirect('ships')->with('message', 'Ship deleted successfully');
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
}
