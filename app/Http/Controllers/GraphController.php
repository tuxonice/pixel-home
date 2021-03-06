<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function show(Request $request)
    {
        $timeDistribution = $request->query('time-distribution', 'series');
        $selectedDeviceId = $request->query('device-id', null);
        $selectedSensorId = $request->query('sensor-id', null);
        $startDate = $request->query('start-date', date("Y-m-d H:i",
            mktime(0, 0, 0, date("m"), date("d")-3, date("Y"))));
        $endDate = $request->query('end-date', date("Y-m-d H:i", 
            mktime(23, 59, 59, date("m"), date("d"), date("Y"))));

        if(!in_array($timeDistribution , ['series','linear'])) {
            $timeDistribution = 'series';
        }
        
        $devices = Device::get();
        
        if($selectedDeviceId) {
            $selectedDevice = Device::find((int)$selectedDeviceId);
        } else {
            $selectedDevice = null;
        }

        if($selectedSensorId) {
            $selectedSensor = Sensor::find((int)$selectedSensorId);
        } else {
            $selectedSensor = null;
        }


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
            $constraints[] = ['added_on', '<=', $endDate];
        }

        $points = collect([]);
        if ($selectedDeviceId && $selectedSensorId) {
            $points = DB::table('points')->where($constraints)
                ->orderBy('added_on', 'asc')->get();
        }

        $averageValue = round($points->avg('value'), 2);
        $minValue = $points->min('value');
        $maxValue = $points->max('value');

        $userTimezone = Auth::user()->timezone;

        $points->map(function ($item, $key) use($userTimezone){
            $item->added_on = Carbon::createFromFormat('Y-m-d H:i:s', $item->added_on, timezone_open('UTC'))
                ->setTimezone($userTimezone)
                ->toDateTimeString();
            return $item;
        });

        return View('graph.show', [
            'points' => $points,
            'selectedDeviceId' => $selectedDeviceId,
            'selectedDevice' => $selectedDevice,
            'selectedSensor' => $selectedSensor,
            'selectedSensorId' => $selectedSensorId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'devices' => $devices,
            'timeDistribution' => $timeDistribution,
            'minValue' => $minValue,
            'maxValue' => $maxValue,
            'averageValue' => $averageValue,
            ]);
    }
}
