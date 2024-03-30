<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IotData;
use DB;
class ITODataController extends Controller
{
    public function index() {
        return view('dashboard.iot.visualization');
    }
    

    public function chartData(Request $request) {
        // Get start and end dates from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Retrieve data from the database based on the date range
        $data = IotData::whereBetween('timestamp', [$startDate, $endDate])
                        ->orderBy('timestamp')
                        ->get();

        $data = IotData::whereBetween('timestamp', [$startDate, $endDate])
        ->select('device_id', DB::raw('COUNT(*) as packet_count'))
        ->groupBy('device_id')
        ->orderBy('device_id')
        ->get();

        // Format data for Chart.js
        $labels = $data->pluck('device_id');
        $values = $data->pluck('packet_count');

        // Return data as JSON
        return response()->json([
        'labels' => $labels,
        'values' => $values,
        ]);

    }

}
