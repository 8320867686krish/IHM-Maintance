<?php

namespace App\Traits;

use App\Models\Hazmat;
use Illuminate\Http\Request;
use App\Models\Ship;
use Carbon\Carbon;

trait ShipData
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getShipData($shipId, $year = null)
    {
        $year = $year ?? Carbon::now()->year;

        $ship = Ship::with(['pOOrderItems', 'pOOrderItemsHazmats', 'exams','brifings'])->find($shipId);
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

            $mdRecoreds[] = $ship->pOOrderItemsHazmats()
                ->whereNotNull('doc1')
                ->whereYear('created_at', $start->year)
                ->whereMonth('created_at', $start->month)
                ->count();

            $sdocRecoreds[] = $ship->pOOrderItemsHazmats()
            ->whereNotNull('doc2')

                ->whereYear('created_at', $start->year)
                ->whereMonth('created_at', $start->month)
                ->count();

            $trainingOverview = $ship->exams()
                ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $start->year) // Filter by the current year
                ->groupBy('month')
                ->pluck('count', 'month')
                ->toArray();

            // Generate a full month-wise dataset with zero as the default count
            $months = collect($trainingOverview)->map(function ($count, $monthNum) {
                return [date('M', mktime(0, 0, 0, $monthNum, 1)), $count];
            })->values()->toArray();

            $brifingOverview = $ship->brifings()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $start->year) // Filter by the current year
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Generate a full month-wise dataset with zero as the default count
        $brfingmonths = collect($brifingOverview)->map(function ($count, $monthNum) {
            return [date('M', mktime(0, 0, 0, $monthNum, 1)), $count];
        })->values()->toArray();

        $hazmatSummeryName = Hazmat::withSum(['checkHazmats as qty_sum' => function ($query) use ($shipId,$year) {
            $query->where('ship_id', $shipId)
                  ->whereYear('created_at',$year);  // Filter by current year
        }], 'qty')->get()->toArray();

            // Move to the next month
            $start->addMonth();
        }

        return ([
            'isStatus' => true,
            'labels' => $labels,
            'monthrelevantCounts' => $monthrelevantCounts,
            'monthnonRelevantCounts' => $monthnonRelevantCounts,
            'mdSdRecoreds' => $mdRecoreds,
            'sdocRecoreds' => $sdocRecoreds,
            'trainingverview' => $months,
            'brifingoverview' => $brfingmonths,
            'hazmatSummeryName' =>  $hazmatSummeryName,
            'ship' => $ship['ship_name']
        ]);
    }
}
