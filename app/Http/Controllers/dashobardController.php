<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashobardController extends Controller
{
    //
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
        $ship = Ship::with('pOOrderItems')->find($shipId);
        $monthrelevantCounts = [];
        $monthnonRelevantCounts = [];
        $start = Carbon::createFromDate(null, 1, 1);  // January 1 of the current year
        $end = Carbon::now(); // Current date
    
        $labels = [];
        
        // Loop from start to end, pushing each month into the $months array
        while ($start <= $end) {
            // Format the month for labeling
            $monthLabel = $start->format('M-y');
            $labels[] = $monthLabel;
            // Count items for each type_category within the current month
            $monthrelevantCounts[] = $ship->pOOrderItems()
                ->where('type_category', 'Relevant')
                ->whereYear('created_at', $start->year)
                ->whereMonth('created_at', $start->month)
                ->count();
    
            $monthnonRelevantCounts[] = $ship->pOOrderItems()
                ->where('type_category', 'Non relevant')
                ->whereYear('created_at', $start->year)
                ->whereMonth('created_at', $start->month)
                ->count();
    
            // Move to the next month
            $start->addMonth();
        }
    
        return response()->json([
            'isStatus' => true, 
            'labels' => $labels,
            'monthrelevantCounts' => $monthrelevantCounts,
            'monthnonRelevantCounts'=>$monthnonRelevantCounts
        ]);

       
    }
}
