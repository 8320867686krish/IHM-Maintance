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
        $monthrelevantCounts = [];
        $monthnonRelevantCounts = [];
        $labels = [];
        $brfingmonths = [];
        $trainingonths = [];
        $mdRecoreds = [];
        $sdocRecoreds = [];
         $monthrelevantCounts = [];
        $monthnonRelevantCounts = [];

        $ship = Ship::find($shipId);
        $hazmatSummeryName = Hazmat::withSum(['checkHazmats as qty_sum' => function ($query) use ($shipId, $year) {
            $query->where('ship_id', $shipId)
                ->whereYear('created_at', $year);  // Filter by current year
        }], 'qty')->get()->toArray();
       
        $start = Carbon::createFromDate($year, 1, 1);  // January 1 of the selected year or current year

        $end = Carbon::createFromDate($year, 12, 31);  // December 31 of the selected year


       
        $brifingOverview = $ship->brifings()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year) // Fetch data for the whole year
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $trainingOverview = $ship->exams()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $start->year)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

    
       
       
        $countsData = $ship->pOOrderItems()
            ->whereYear('created_at', $year)
            ->selectRaw("
        MONTH(created_at) as month, 
        SUM(CASE WHEN type_category = 'Relevant' THEN 1 ELSE 0 END) as relevant_count, 
        SUM(CASE WHEN type_category = 'Non relevant' THEN 1 ELSE 0 END) as non_relevant_count
    ")
            ->groupBy('month')
            ->get()
            ->keyBy('month'); // Convert collection into key-value pair based on month

        // Initialize result arrays
       
        $sdmdcountsData = $ship->pOOrderItemsHazmats()
            ->whereYear('created_at', $year)
            ->selectRaw("
        MONTH(created_at) as month, 
        SUM(CASE WHEN doc1 IS NOT NULL THEN 1 ELSE 0 END) as md_count, 
        SUM(CASE WHEN doc2 IS NOT NULL THEN 1 ELSE 0 END) as sdoc_count
    ")
            ->groupBy('month')
            ->get()
            ->keyBy('month'); // Convert collection into key-value pair based on month

        // Initialize result arrays
     
      

        // Loop from start to end, pushing each month into the $months array
        while ($start <= $end) {
            // Format the month for labeling
            $monthLabel = $start->format('M');
            $monthNum = $start->month;

            $labels[] = $monthLabel;
            // Count items for each type_category within the current month
            $monthrelevantCounts[] = $countsData[$monthNum]->relevant_count ?? 0;
            $monthnonRelevantCounts[] = $countsData[$monthNum]->non_relevant_count ?? 0;



            $mdRecoreds[] = $sdmdcountsData[$monthNum]->md_count ?? 0;
            $sdocRecoreds[] = $sdmdcountsData[$monthNum]->sdoc_count ?? 0;



            // Generate a full month-wise dataset with zero as the default count
            $months = collect($trainingOverview)->map(function ($count, $monthNum) {
                return [date('M', mktime(0, 0, 0, $monthNum, 1)), $count];
            })->values()->toArray();


            if (!empty($trainingOverview[$monthNum])) {
                $trainingonths[] = [$monthLabel, $trainingOverview[$monthNum]];
            }
            if (!empty($brifingOverview[$monthNum])) {

            // Generate a full month-wise dataset with zero as the default count
            $brfingmonths[] = [$monthLabel, $brifingOverview[$monthNum]];
            }




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
            'trainingverview' => $trainingonths,
            'brifingoverview' => $brfingmonths,
            'hazmatSummeryName' =>  $hazmatSummeryName,
            'ship' => $ship['ship_name']
        ]);
    }

    public function getAllhip($type = null, $year = null)
    {
        $year = $year ?? Carbon::now()->year;
        $user_id = Auth::user()->id;
        $months = [];
        $start = Carbon::createFromDate($year, 1, 1); // Start of year
        $end = Carbon::createFromDate($year, 12, 1); // End of year
        while ($start <= $end) {
            $months[] = $start->format('M'); // Format as "Jan", "Feb", etc.
            $start->addMonth(); // Move to next month
        }

        if ($type == 'brifings') {
            $ships = Ship::with(['brifings' => function ($query)  use ($year) {
                $query->whereYear('created_at', $year)
                    ->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        } else if ($type == 'onboard') {
            $ships = Ship::with(['exams' => function ($query) use ($year) {
                $query->whereYear('created_at', $year)
                    ->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        } else if ($type == "mdrecords") {
            $ships = Ship::with(['pOOrderItemsHazmats' => function ($query) use ($year) {
                $query->whereNotNull('doc1')
                    ->whereYear('created_at', $year) // Filter by the current year
                    ->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        } else if ($type == 'sdrecords') {
            $ships = Ship::with(['pOOrderItemsHazmats' => function ($query) use ($year) {

                $query->whereNotNull('doc2')
                    ->whereYear('created_at', $year) // Filter by the current year
                    ->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
                    ->groupBy('ship_id', 'month');
            }])->where('client_user_id', $user_id)->get();
        } else {
            $ships = Ship::with(['pOOrderItems' => function ($query) use ($year) {
                $query->whereYear('created_at', $year)
                    ->selectRaw('ship_id, DATE_FORMAT(created_at, "%b") as month, COUNT(*) as count')
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
            if ($type == 'onboard') {
                $datarelationship = $ship->exams;
            } else if ($type == 'brifings') {
                $datarelationship = $ship->brifings;
            } else if ($type == 'mdrecords' || $type == 'sdrecords') {
                $datarelationship = $ship->pOOrderItemsHazmats;
            } else {
                $datarelationship = $ship->pOOrderItems;
            }
            foreach ($datarelationship as $item) {
                $monthData[$item->month] = $item->count; // Fill in actual count
            }

            $data = array_merge($data, array_values($monthData)); // Ensure correct order
            $chartData['columns'][] = $data;
            $chartData['colors'][$ship->ship_name] = $shipColors[$index % count($shipColors)];
        }

        return $chartData;
    }
}
