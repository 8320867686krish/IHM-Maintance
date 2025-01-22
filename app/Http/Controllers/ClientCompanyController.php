<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientCompanyRequest;
use App\Models\ClientCompany;
use App\Models\hazmatCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;

class ClientCompanyController extends Controller
{
    //
    use ImageUpload;

    public function index()
    {
        $role_level = Auth::user()->roles->first()->level;
        $user =  Auth::user();
        if ($role_level == 2) {
            $clients = ClientCompany::with(['hazmatCompaniesId', 'userDetail'])->where('hazmat_companies_id', $user['hazmat_companies_id'])->get();
        }
        if ($role_level == 3) {
            $clients = ClientCompany::with(['hazmatCompaniesId', 'userDetail'])->where('hazmat_companies_id', $user['hazmat_companies_id'])->where('created_by', $user->id)->get();
        } else {
            $clients = ClientCompany::with(['hazmatCompaniesId', 'userDetail'])->get();
        }

        return view('clientCompany.list', ['clientCompany' => $clients]);
    }
    public function create()
    {
        $user =  Auth::user();
        $currentUserRoleLevel = Auth::user()->roles->first()->level;
        $hazmat_companies_id = $user->hazmat_companies_id;
        $created_by = $user->id;
        $hazmetCompany = hazmatCompany::select('id', 'name')->get();


        $hazmetCompany = hazmatCompany::select('id', 'name')->get();
        return view('clientCompany.add', ['head_title' => 'Add', 'button' => 'Save', 'hazmat_companies_id' => $hazmat_companies_id, 'created_by' => $created_by, 'currentUserRoleLevel' => $currentUserRoleLevel, 'hazmetCompany' => $hazmetCompany]);
    }
    public function edit(string $id)
    {
        try {
            $client_company = ClientCompany::find($id);
            $user =  Auth::user();
            $user_client_company = User::find($client_company['user_id']);
            $currentUserRoleLevel = Auth::user()->roles->first()->level;
            $hazmetCompany = hazmatCompany::select('id', 'name')->get();

            $hazmat_companies_id = $user->hazmat_companies_id;
            $created_by = $user->id;
            return view('clientCompany.add', ['head_title' => 'Edit', 'button' => 'Update', 'clientCompany' => $client_company, 'hazmat_companies_id' => $hazmat_companies_id, 'created_by' => $created_by, 'user' => $user_client_company, 'currentUserRoleLevel' => $currentUserRoleLevel, 'hazmetCompany' => $hazmetCompany]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function store(ClientCompanyRequest $request)
    {
        try {
            $id = $request->input('id');

            $inputData = $request->all();
            $userdata = [
                'name' =>   $inputData['name'],
                'email' =>   $inputData['email'],
                'phone' =>   $inputData['phone'],
                'password' => $inputData['password'],
                'hazmat_companies_id' => $inputData['hazmat_companies_id']
            ];
            $clicntCompany = ClientCompany::find($inputData['id']);

            if ($request->hasFile('client_image')) {
                if ($inputData['id'] != 0) {
                    if ($clicntCompany && $clicntCompany->client_image) {
                        $oldImagePath = $this->deleteImage('uploads/clientcompany/', $clicntCompany->client_image);
                    }
                }
                $image = $this->upload($request, 'client_image', 'uploads/clientcompany');
                $inputData['client_image'] = $image;
            }
            if ($request->hasFile('material')) {
                if ($inputData['id'] != 0) {
                    if ($clicntCompany && $clicntCompany->material) {
                        $oldImagePath = $this->deleteImage('uploads/clientcompany/training_materials/', $clicntCompany->material);
                    }
                }
                $image = $this->upload($request, 'material', 'uploads/clientcompany/training_materials');
                $inputData['material'] = $image;
            }

            if ($id == 0) {

                $user = User::create($userdata);
                $role_id = Role::where('level', 5)->pluck('id')->first();
                $user->assignRole([$role_id]);
                $inputData['user_id'] = $user->id;
            } else {
                if (@!$userdata['password']) {
                    unset($userdata['password']);
                }
                User::updateOrCreate(['id' => $inputData['user_id']], $userdata);
            }
            unset($inputData['passord']);


            ClientCompany::updateOrCreate(['id' => $id], $inputData);

            $message = empty($id) ? "Client Comapny added successfully" : "Client Company updated successfully";

            // return redirect('clients')->with('message', $message);
            return response()->json(['isStatus' => true, 'message' => $message]);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
            return response()->json(['isStatus' => false, 'message' => 'An error occurred while processing your request.']);
        }
    }

    public function destroy(string $id)
    {
        try {
            $clientCompany = ClientCompany::findOrFail($id);
            $user = User::findOrFail($clientCompany['user_id']);
            $user->delete();
            $clientCompany->delete();
            return response()->json(['isStatus' => true, 'message' => 'Client Company deleted successfully']);
        } catch (\Throwable $th) {
            return response()->json(['isStatus' => false, 'message' => 'Client Company not deleted successfully']);
        }
    }
}
