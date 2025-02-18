<?php

namespace App\Traits;

use App\Models\Hazmat;
use Illuminate\Http\Request;
use App\Models\Ship;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ShipData
{

    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function getShipData($shipId, $year = null)
    {
        $year = $year ?? Carbon::now()->year;

        $ship = Ship::with(['pOOrderItems', 'pOOrderItemsHazmats', 'exams', 'brifings'])->find($shipId);
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

            $hazmatSummeryName = Hazmat::withSum(['checkHazmats as qty_sum' => function ($query) use ($shipId, $year) {
                $query->where('ship_id', $shipId)
                    ->whereYear('created_at', $year);  // Filter by current year
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

    public function getAllhip($type = null,$year = null)
    {
        $user_id = Auth::user()->id;
        
        if ($type == 'brifings') {
           
            $months = DB::table('brifings')
                ->selectRaw('DATE_FORMAT(created_at, "%b") as month, DATE_FORMAT(created_at, "%Y-%m") as full_month')
                ->groupBy('full_month', 'month')
                ->orderBy('full_month')
                ->pluck('month')
                ->toArray();

            $ships = Ship::with(['brifings' => function ($query) {
                $query->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id',$user_id)->get();
          
        }
       else if ($type == 'onboard') {
            $months = DB::table('exams')
                ->selectRaw('DATE_FORMAT(created_at, "%b") as month, DATE_FORMAT(created_at, "%Y-%m") as full_month')
                ->groupBy('full_month', 'month')
                ->orderBy('full_month')
                ->pluck('month')
                ->toArray();

            $ships = Ship::with(['exams' => function ($query) {
                $query->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        } else {
            $months = DB::table('po_order_items')
                ->selectRaw('DATE_FORMAT(created_at, "%b") as month, DATE_FORMAT(created_at, "%Y-%m") as full_month')
                ->groupBy('full_month', 'month')
                ->orderBy('full_month')
                ->pluck('month')
                ->toArray();

            $ships = Ship::with(['pOOrderItems' => function ($query) {
                $query->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        }

        $chartData = [
            'columns' => [],
            'colors' => []
        ];

        $chartData['columns'][] = array_merge(["x"], $months); // X-axis (Months)

        $shipColors = ['#5969ff', '#ff407b', '#28a745']; // Define colors for ships

        foreach ($ships as $index => $ship) {
            $data = [$ship->ship_name]; // Ship name as series
            $monthData = array_fill_keys($months, 0); // Ensure all months exist

            foreach ($ship->pOOrderItems as $item) {
                $monthData[$item->month] = $item->count; // Fill in actual count
            }

            $data = array_merge($data, array_values($monthData)); // Ensure correct order
            $chartData['columns'][] = $data;
            $chartData['colors'][$ship->ship_name] = $shipColors[$index % count($shipColors)];
        }
        return $chartData;
    }
}
