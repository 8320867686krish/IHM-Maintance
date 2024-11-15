<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Traits\ShipData;
class dashobardController extends Controller
{
    //
    use ShipData;
    public function index(){
        $user = Auth::user();

        $currentUserRoleLevel = $user->roles->first()->level;

        // Initialize the query for ships
        if ($currentUserRoleLevel == 3 || $currentUserRoleLevel == 4) {
            $ships = $user->ships->load('client');
        } else {
            // Otherwise, start with a query builder
            $shipsQuery = Ship::select('id','ship_name')->with('pOOrderItems');

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
       
        return view('dashboard',compact('ships','shipsPo','relevantCounts','nonRelevantCounts'));
    }
    public function shipwiseData($shipId){
        $data = $this->getShipData($shipId);
        return $data;
       
    }
}
