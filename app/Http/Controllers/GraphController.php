<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Sensor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GraphController extends Controller
{
    public function show(Request $request)
    {
        $timeDistribution = $request->query('time-distribution', 'series');
        $selectedDeviceId = $request->query('device-id', null);
        $selectedSensorId = $request->query('sensor-id', null);
        $startDate = $request->query('start-date', date("Y-m-d",
            mktime(0, 0, 0, date("m"), date("d")-3, date("Y"))));
        $endDate = $request->query('end-date', date("Y-m-d"));

        if(!in_array($timeDistribution , ['series','linear'])) {
            $timeDistribution = 'series';
        }
        
        $devices = Device::get();
        $sensors = Sensor::get();

        $constraints = [];
        
        if ($selectedDeviceId) {
            $constraints[] = ['device_id', $selectedDeviceId];
        }

        if ($selectedSensorId) {
            $constraints[] = ['sensor_id', $selectedSensorId];
        }

        if ($startDate) {
            $constraints[] = ['added_on', '>=', $startDate];
        }

        if ($endDate) {
            $constraints[] = ['added_on', '<=', $endDate . ' 23:59:59'];
        }

        $points = DB::table('points')->where($constraints)
        ->orderBy('added_on', 'asc')->get();
        
        $userTimezone = Auth::user()->timezone;

        $events->map(function ($item, $key) use($userTimezone){
            $item->added_on = Carbon::createFromFormat('Y-m-d H:i:s', $item->added_on, timezone_open('UTC'))
                ->setTimezone($userTimezone)
                ->toDateTimeString();
            return $item;
        });
        
        $grouped = $events->mapToGroups(function ($item, $key) {
            return [$item->sensorName => $item];
        });
        
        $graphColor = [];
        $index = 1;
        foreach ($grouped as $key => $value) {
            $graphColor[$key] = $this->HSVtoRGB([(($index++)/count($grouped)), 0.8, 0.8]);
        }

        return View('graph.show', [
            'points' => $points,
            'selectedDeviceId' => $selectedDeviceId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'devices' => $devices,
            'timeDistribution' => $timeDistribution
            ]);
    }
}
