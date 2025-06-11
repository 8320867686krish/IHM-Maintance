<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Jobs\sendUserRegisterMail;
use App\Models\hazmatCompany;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    //
    public function create()
    {
        $user =  Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;

        $hazmat_companies_id  = 0;
        if ($currentUserRoleLevel != 1) {
            $hazmat_companies_id = $user->hazmat_companies_id;
        }
        $hazmetCompany = hazmatCompany::select('id', 'name')->get();
        $roles = Role::where('level', '>', $currentUserRoleLevel)->get();

        return view('user.userAdd', ['roles' => $roles, 'button' => 'Save', 'head_title' => 'Add', 'hazmat_companies_id' => $hazmat_companies_id, 'hazmetCompany' => $hazmetCompany, 'currentUserRoleLevel' => $currentUserRoleLevel]);
    }
    public function index()
    {
        try {
            $role_id = Auth::user()->roles->first()->level;
            $user =  Auth::user();

            if ($role_id != 1) {
                $users = User::with('hazmatCompaniesId')->whereHas('roles', function ($query) use ($role_id) {
                    $query->where('level', '>', $role_id)->orderBy('level', 'asc');
                })->where('hazmat_companies_id', $user->hazmat_companies_id)->get();
            } else {
                $users = User::with('hazmatCompaniesId')->get();
            }


            return view('user.user', ['users' => $users]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }

    public function store(UserRequest $request)
    {
        try {
            $id = $request->input('id');
            $inputData = $request->input();

            if (!@$inputData['password']) {
                unset($inputData['password']);
            }

            $role_id = Role::where('level', $request->input('roles'))->pluck('id')->first();
            $inputData['hazmat_companies_id'] = $inputData['hazmat_companies_id'];
            $user = User::updateOrCreate(['id' => $id], $inputData);

            // Assign the role to the user
            $user->assignRole([$role_id]);
            $message = empty($id) ? "User created successfully" : "User updated successfully";
            if ($id == 0) {
                $userMailData = [
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
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
            return response()->json(['isStatus' => false, 'message' => $th->getMessage()]);
        }
    }
    public function edit(string $id)
    {
        try {
            $currentUserRoleLevel = Auth::user()->roles->first()->level;
            $user =  Auth::user();
            $hazmat_companies_id = 0;
            if ($currentUserRoleLevel != 1) {
                $hazmat_companies_id = $user->hazmat_companies_id;
            }
            $hazmetCompany = hazmatCompany::select('id', 'name')->get();
            if ($currentUserRoleLevel != 1) {
                $roles = Role::where('level', '>', $currentUserRoleLevel)->get();
            } else {
                $roles = Role::get();
            }

            $user = User::find($id);
            $role = $user->getRoleNames();
            $user['role'] = $role[0];
            $user['roleLevel'] = $currentUserRoleLevel;
            unset($user->password, $user->created_at, $user->updated_at);

            return view('user.userAdd', ['roles' => $roles, 'button' => 'Update', 'head_title' => 'Edit', 'user' => $user, 'hazmat_companies_id' => $hazmat_companies_id, 'hazmetCompany' => $hazmetCompany]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
}
