<?php
namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Ship;
use Carbon\Carbon;
trait ShipData {

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getShipData($shipId) {
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
    
        return ([
            'isStatus' => true, 
            'labels' => $labels,
            'monthrelevantCounts' => $monthrelevantCounts,
            'monthnonRelevantCounts'=>$monthnonRelevantCounts
        ]);
    }

  
}