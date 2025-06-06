<?php

namespace App\Http\Controllers;

use App\Http\Requests\hazmatCompanyRequest;
use App\Jobs\sendUserRegisterMail;
use App\Models\hazmatCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;

class HazmatCompanyController extends Controller
{

    use ImageUpload;
    //
    public function index()
    {
        $hazmatCompany = hazmatCompany::get();
        return view('hazmatCompany.index', ['hazmatCompany' => $hazmatCompany]);
    }
    public function create()
    {
        return view('hazmatCompany.create', ['head_title' => 'Add', 'button' => 'Save']);
    }
    public function edit(string $id)
    {
        try {
            $role_id = Role::where('level', 2)->pluck('id')->first();

            $user = User::whereHas('roles', function ($query) use ($role_id) {
                $query->where('id', $role_id);
            })->where('hazmat_companies_id', $id)->first();

            $hazmatCompany = hazmatCompany::select('id', 'name', 'email', 'first_name', 'last_name', 'phone', 'logo')->find($id);
            return view('hazmatCompany.create', ["hazmatCompany" => $hazmatCompany, 'head_title' => 'Edit', 'button' => 'Update', 'user' => $user]);
        } catch (\Throwable $e) {
            return back()->withError($e->getMessage())->withInput();
        }
    }
    public function store(hazmatCompanyRequest $request)
    {
        try {
            $post = $request->input();
            $userData = [
                'password' => $post['password']
            ];
            unset($post['password']);
            $hazmatCompany = hazmatCompany::find($post['id']);

            if ($request->hasFile('logo')) {
                if ($post['id'] != 0) {
                    $hazmatCompany = hazmatCompany::find($post['id']);
                    if ($hazmatCompany && $hazmatCompany->logo) {
                        $oldImagePath = $this->deleteImage('uploads/hazmatCompany/', $hazmatCompany->logo);
                    }
                }
                $image = $this->upload($request, 'logo', 'uploads/hazmatCompany');
                $post['logo'] = $image;
            }

            if ($request->hasFile('training_material')) {
                if ($post['id'] != 0) {
                    if ($hazmatCompany && $hazmatCompany->training_material) {
                        $oldImagePath = $this->deleteImage('uploads/training_material/', $hazmatCompany->training_material);
                    }
                }
                $image = $this->upload($request, 'training_material', 'uploads/training_material');
                $post['training_material'] = $image;
            }

            if ($request->hasFile('briefing_plan')) {
                if ($post['id'] != 0) {
                    if ($hazmatCompany && $hazmatCompany->briefing_plan) {
                        $oldImagePath = $this->deleteImage('uploads/briefing_plan/', $hazmatCompany->briefing_plan);
                    }
                }
                $image = $this->upload($request, 'briefing_plan', 'uploads/briefing_plan');
                $post['briefing_plan'] = $image;
            }

            $hazmatCompany = hazmatCompany::updateOrCreate(['id' => $request->input('id')], $post);
            unset($userData['logo']);
            $userData['name'] = $post['first_name'];
            $userData['last_name'] = $post['last_name'];
            $userData['email'] = $post['email'];
            $userData['phone'] = $post['phone'];

            if ($post['id'] == 0) {

                $userData['hazmat_companies_id'] = $hazmatCompany->id;
                $user = User::create($userData);
                $role_id = Role::where('level', 2)->pluck('id')->first();

                $user->assignRole([$role_id]);
            } else {
                if (@!$userData['password']) {
                    unset($userData['password']);
                }
                $user = User::updateOrCreate(['id' => $request->input('user_id')], $userData);
            }
            $message = empty($request->input('id')) ? "HazmatCompany added successfully" : "HazmatCompany updated successfully";
            $userMailData = [
                'name' => $userData['name'],
                'last_name' =>  $userData['last_name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
            ];
            try {
                dispatch(new sendUserRegisterMail($userMailData));
                return response()->json(['isStatus' => true, 'message' => $message]);
            } catch (\Exception $e) {
                return response()->json(['isStatus' => false, 'message' => 'User created successfully, but failed to send welcome email']);
            }
            return response()->json(['isStatus' => true, 'message' => $message]);
        } catch (\Throwable $e) {
            print_r($e->getMessage());
            // return back()->withError($e->getMessage())->withInput();
        }
    }
    public function destroy(string $id)
    {
        try {

            $HazmatCompany = HazmatCompany::findOrFail($id);
            $this->deleteImage('uploads/hazmatCompany/', $HazmatCompany['logo']);
            $HazmatCompany->delete();

            // return redirect('clients')->with('message', 'Client deleted successfully');
            return response()->json(['isStatus' => true, 'message' => 'Hazmat Comapny deleted successfully']);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            // return back()->withError($th->getMessage());
            return response()->json(['isStatus' => false, 'message' => 'Hazmat Comapny not deleted successfully']);
        }
    }
}
