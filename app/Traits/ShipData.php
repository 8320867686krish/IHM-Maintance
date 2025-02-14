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
    public function getShipData($shipId,$year=null) {
        $year = $year ?? Carbon::now()->year;

        $ship = Ship::with(['pOOrderItems','pOOrderItemsHazmats'])->find($shipId);
        $monthrelevantCounts = [];
        $monthnonRelevantCounts = [];
        $start = Carbon::createFromDate($year, 1, 1);  // January 1 of the selected year or current year

        $end = Carbon::createFromDate($year, 12, 31);  // December 31 of the selected year

    
        $labels = [];
        
        // Loop from start to end, pushing each month into the $months array
        while ($start <= $end) {
            // Format the month for labeling
            $monthLabel = $start->format('M');
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

            $mdSdRecoreds[]=$ship->pOOrderItemsHazmats()
            ->whereYear('created_at', $start->year)
            ->whereMonth('created_at', $start->month)
            ->groupBy('model_make_part_id')
            ->count();
              
    
            // Move to the next month
            $start->addMonth();
        }
    
        return ([
            'isStatus' => true, 
            'labels' => $labels,
            'monthrelevantCounts' => $monthrelevantCounts,
            'monthnonRelevantCounts'=>$monthnonRelevantCounts,
            'mdSdRecoreds'=>$mdSdRecoreds
        ]);
    }

  
}