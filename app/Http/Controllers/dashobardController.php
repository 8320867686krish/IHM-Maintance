<?php

namespace App\Http\Controllers;

use App\Http\Requests\configrationRequest;
use App\Models\configration;
use App\Models\Ship;
use App\Traits\ImageUpload;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Traits\ShipData;

class dashobardController extends Controller
{
    //
    use ShipData;
    use ImageUpload;
    public function index()
    {
        $user = Auth::user();
        $designatePerson = $user->designatedPerson;
        $currentUserRoleLevel = $user->roles->first()->level;
        $currentUserRoleName = $user->roles->first()->name;
        // Initialize the query for ships
        if ($currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $ships = $user->ships->load('client');
        } else {
            // Otherwise, start with a query builder
            $shipsQuery = Ship::select('id', 'ship_name')->with('pOOrderItems');

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

        $relevantCounts = $ships->map(function ($ship) {
            return $ship->pOOrderItems()->where('type_category', 'Relevant')->count();
        })->toArray();

        $nonRelevantCounts = $ships->map(function ($ship) {
            return $ship->pOOrderItems()->where('type_category', 'Non relevant')->count();
        })->toArray();

        $shipsPo = $ships->pluck('ship_name')->toArray();

        return view('dashboard', compact('ships', 'shipsPo', 'relevantCounts', 'nonRelevantCounts', 'currentUserRoleLevel', 'designatePerson', 'currentUserRoleName'));
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
