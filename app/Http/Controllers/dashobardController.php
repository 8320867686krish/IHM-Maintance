<?php

namespace App\Http\Controllers;

use App\Http\Requests\configrationRequest;
use App\Http\Requests\profileRequest;
use App\Models\ClientCompany;
use App\Models\configration;
use App\Models\Hazmat;
use App\Models\hazmatCompany;
use App\Models\Ship;
use App\Models\User;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Traits\ShipData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class dashobardController extends Controller
{
    //
    use ShipData;
    use ImageUpload;
    public function profile(){
        $user = Auth::user();
        return view('profile',compact('user'));
    }
    public function saveProfile(profileRequest $request){
        $post = $request->input();
        $user = Auth::user();
        if ($request->has('image')) {

            if (@$user && @$user->image) {
                $oldImagePath = $this->deleteImage('uploads/logo/', $user->image);
            }

            $image = $this->upload($request, 'image', 'uploads/logo');
            $post['image'] =  $image;
        }
        User::updateOrCreate(['id' => $user->id],$post);
        return redirect('dashboard');
    }
    public function index()
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;

        $currentUserRoleName = $user->roles->first()->name;
        if ($currentUserRoleLevel == 5) {
            $chartData = $this->getAllhip();
        }else{
            $chartData = [];
        }



        if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $hazmatCompany = ClientCompany::where('hazmat_companies_id', $user->hazmat_companies_id)->get();
            $imagekey = 'client_image';
            $title = "Client Company";
            $routename = 'clientcompany.ships';
            $path = asset('uploads/clientcompany');
        } else if ($currentUserRoleLevel == 1) {
            $hazmatCompany = HazmatCompany::select('id', 'logo', 'name')->get()->toArray();
        
            $path = asset('uploads/hazmatCompany');
            $imagekey = 'logo';
            $title = "Hazmat Company";
            $routename = "clientcompany";
        } else if ($currentUserRoleLevel == 5) {
            $hazmatCompany = Ship::where('client_user_id', $user->id)->get();
            $path = asset('uploads/ship');
            $imagekey = 'ship_image';
            $title = "Ships";
            $routename = "ship.dashboard";
        } else {
            return  $this->shipDashboard($user->shipClient->id);
        }
        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename','chartData'));
    }
    public function clientcompany($id)
    {
        $chartData = [];
        $user = Auth::user();
        $hazmatCompany = ClientCompany::where('hazmat_companies_id', $id)->get();
        $imagekey = 'client_image';
        $title = "Client Company";
        $routename = 'clientcompany.ships';
        $path = asset('uploads/clientcompany');

        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename'));
    }
    public function clientcompanyShips($id)
    {
        $chartData = [];
        $user = Auth::user();
        $client_company_id = $id;
        $hazmatCompany = Ship::where('client_company_id', $id)->get();
        $imagekey = 'ship_image';
        $title = "Ships";
        $routename = "ship.dashboard";

        $path = asset('uploads/ship');

        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename','client_company_id'));
    }
    public function shipDashboard($id)
    {
        $ship_id = $id;
        $user = Auth::user();
        $anyliticsdata = $this->getShipData($id);
        return view('ship-dashboard', compact('anyliticsdata', 'ship_id'));
    }
    public function configration(Request $request)
    {
        $configration = Configration::first();
        return view('configration', compact('configration'));
    }
    public function configrationSave(Request $request)
    {
        $post = $request->input();
        $configration = configration::find($post['id']);
        if ($request->has('ship_staff')) {

            if (@$configration && @$configration->ship_staff) {
                $oldImagePath = $this->deleteImage('uploads/configration/', $configration->ship_staff);
            }

            $image = $this->upload($request, 'ship_staff', 'uploads/configration');
            $post['ship_staff'] =  $image;
        }
        if ($request->has('client_company')) {
            if (@$configration && @$configration->client_company) {
                $oldImagePath = $this->deleteImage('uploads/configration/', $configration->client_company);
            }

            $image = $this->upload($request, 'client_company', 'uploads/configration');
            $post['client_company'] =  $image;
        }
        if ($request->has('hazmat_company')) {
            if (@$configration && @$configration->hazmat_company) {
                $oldImagePath = $this->deleteImage('uploads/configration/', $configration->hazmat_company);
            }
            $image = $this->upload($request, 'hazmat_company', 'uploads/configration');
            $post['hazmat_company'] =  $image;
        }
        $configration = configration::updateOrCreate(['id' => $request->input('id')], $post);

        return response()->json(['isStatus' => true, 'message' => 'save successfully']);
    }
    public function shipwiseData($shipId, $selectedDate)
    {
        $data = $this->getShipData($shipId, $selectedDate);
        return $data;
    }
    public function allshipsData($type,$date){
        $data = $this->getAllhip($type,$date);    
        return $data;
    }
}
