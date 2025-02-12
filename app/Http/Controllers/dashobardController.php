<?php

namespace App\Http\Controllers;

use App\Http\Requests\configrationRequest;
use App\Models\ClientCompany;
use App\Models\configration;
use App\Models\Hazmat;
use App\Models\hazmatCompany;
use App\Models\Ship;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Traits\ShipData;
use Illuminate\Support\Facades\DB;

class dashobardController extends Controller
{
    //
    use ShipData;
    use ImageUpload;
    public function index()
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $currentUserRoleName = $user->roles->first()->name;


        if ($currentUserRoleLevel == 2 || $currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $hazmatCompany = ClientCompany::where('hazmat_companies_id', $user->hazmat_companies_id)->get();
            $imagekey = 'client_image';
            $title = "Client Company";
            $routename = 'clientcompany.ships';
            $path = asset('uploads/clientcompany');
        } else if ($currentUserRoleLevel == 1) {
            $hazmatCompany = hazmatCompany::get();

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
        }else{
           return  $this->shipDashboard($user->shipClient->id);
        }
        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename','currentUserRoleLevel'));
    }
    public function clientcompany($id)
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $hazmatCompany = ClientCompany::where('hazmat_companies_id', $id)->get();
        $imagekey = 'client_image';
        $title = "Client Company";
        $routename = 'clientcompany.ships';
        $path = asset('uploads/clientcompany');

        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename','currentUserRoleLevel'));
    }
    public function clientcompanyShips($id)
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $hazmatCompany = Ship::where('client_company_id', $id)->get();
        $imagekey = 'ship_image';
        $title = "Ships";
        $routename = "ship.dashboard";

        $path = asset('uploads/ship');

        return view('dashboard', compact('hazmatCompany', 'path', 'imagekey', 'title', 'routename','currentUserRoleLevel'));
    }
    public function shipDashboard($id)
    {
        $user = Auth::user();
        $currentUserRoleLevel = $user->roles->first()->level;
        $anyliticsdata = $this->getShipData($id);
        $hazmatSummeryName = Hazmat::withSum(['checkHazmats as qty_sum' => function ($query) use ($id) {
            $query->where('ship_id', $id);
        }], 'qty')->get()->toArray();

     $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

     $trainingverview = DB::table('exams')
     ->select(DB::raw("DATE_FORMAT(created_at, '%b') as month"), DB::raw('COUNT(*) as count'))
     ->groupBy('month')
     ->orderBy(DB::raw("STR_TO_DATE(month, '%b')")) // Ensures proper month order
     ->where('ship_id',$id)
     ->get()
     ->pluck('count', 'month')
     ->toArray();

     $trainingverviewData = array_map(fn($month) => [$month, $trainingverview[$month] ?? 2], $months);

     $brifingsRecoreds = DB::table('brifings')
     ->select(DB::raw("DATE_FORMAT(created_at, '%b') as month"), DB::raw('COUNT(*) as count'))
     ->groupBy('month')
     ->orderBy(DB::raw("STR_TO_DATE(month, '%b')")) // Ensures proper month order
     ->where('ship_id',$id)
     ->get()
     ->pluck('count', 'month')
     ->toArray();

     $brifingViewData = array_map(fn($month) => [$month, $brifingsRecoreds[$month] ?? 2], $months);


        return view('ship-dashboard', compact('anyliticsdata', 'hazmatSummeryName','trainingverviewData','brifingViewData'));
    }
    public function configration(Request $request)
    {
        $configration = Configration::first();
        return view('configration', compact('configration'));
    }
    public function configrationSave(configrationRequest $request)
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
    public function shipwiseData($shipId)
    {
        $data = $this->getShipData($shipId);
        return $data;
    }
}
