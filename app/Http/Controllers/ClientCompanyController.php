<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientCompanyRequest;
use App\Jobs\sendUserRegisterMail;
use App\Models\ClientCompany;
use App\Models\hazmatCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Traits\ImageUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        } else if ($role_level == 3) {
            $clients = ClientCompany::with(['hazmatCompaniesId', 'userDetail'])->where('hazmat_companies_id', $user['hazmat_companies_id'])->where('created_by', $user->id)->get();
        } else {
            $clients = ClientCompany::with(['hazmatCompaniesId', 'userDetail'])->get();
        }

        return view('clientCompany.list', ['clientCompany' => $clients]);
    }
    public function create($id = null)
    {
        $user =  Auth::user();
        $hazmat_companies_id = $user->hazmat_companies_id;
        $created_by = $user->id;
        $hazmetCompany = hazmatCompany::select('id', 'name')->get();
        $clientCompany = $id ? ClientCompany::find($id) : null;


        $hazmetCompany = hazmatCompany::select('id', 'name')->get();
        return view('clientCompany.add', ['head_title' => 'Add', 'button' => 'Save', 'hazmat_companies_id' => $hazmat_companies_id, 'created_by' => $created_by, 'hazmetCompany' => $hazmetCompany, 'clientCompany' => $clientCompany]);
    }
    public function edit(string $id)
    {
        try {
            $client_company = ClientCompany::find($id);
            $user =  Auth::user();
            $user_client_company = User::find($client_company['user_id']);
            $hazmetCompany = hazmatCompany::select('id', 'name')->get();

            $hazmat_companies_id = $user->hazmat_companies_id;
            $created_by = $user->id;
            return view('clientCompany.add', ['head_title' => 'Edit', 'button' => 'Update', 'clientCompany' => $client_company, 'hazmat_companies_id' => $hazmat_companies_id, 'created_by' => $created_by, 'user' => $user_client_company, 'hazmetCompany' => $hazmetCompany]);
        } catch (\Throwable $th) {
            return back()->withError($th->getMessage())->withInput();
        }
    }
    public function store(ClientCompanyRequest $request)
    {
          DB::beginTransaction(); // Start transaction
        try {
            $id = $request->input('id');
            $inputData = $request->all();
            $inputData['isSameAsManager'] = $request->has('isSameAsManager') ? 1 : 0;

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
                if ($inputData['isSameAsManager']) {
                    $inputData['owner_logo'] = $inputData['client_image'];
                }
            }

            if ($request->hasFile('owner_logo')) {
                if ($inputData['id'] != 0) {
                    if ($clicntCompany && $clicntCompany->owner_logo) {
                        $oldImagePath = $this->deleteImage('uploads/clientcompany/', $clicntCompany->owner_logo);
                    }
                }
                $image = $this->upload($request, 'owner_logo', 'uploads/clientcompany');
                $inputData['owner_logo'] = $image;
            } elseif ($inputData['isSameAsManager'] && $id) {
                $inputData['owner_logo'] = ClientCompany::where('id', $id)->value('client_image');
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

            $userMailData = [
                'name' => $inputData['name'],
                'last_name' =>'',
                'email' => $inputData['email'],
                'password' => $inputData['password'],
            ];
            ClientCompany::updateOrCreate(['id' => $id], $inputData);
            DB::commit(); // Commit DB transaction
            $message = empty($id) ? "Client Comapny added successfully" : "Client Company updated successfully";

            try {
                dispatch(new sendUserRegisterMail($userMailData));
                return response()->json(['isStatus' => true, 'message' => $message]);
            } catch (\Exception $e) {
                return response()->json(['isStatus' => false, 'message' => 'User created successfully, but failed to send welcome email']);
            }

            // return redirect('clients')->with('message', $message);
            return response()->json(['isStatus' => true, 'message' => $message]);
        } catch (\Throwable $th) {
             DB::rollBack(); // Rollback DB transaction
          //  print_r($th->getMessage());
            return response()->json(['isStatus' => false, 'message' => $th->getMessage()]);
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
