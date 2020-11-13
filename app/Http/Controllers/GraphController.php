<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sensor;
use App\Models\Device;

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
            $constraints[] = ['added_on', '<=', $endDate . ' 23:59:59'];
        }

        $points = DB::table('points')->where($constraints)
        ->orderBy('added_on', 'asc')->get();
        
        return View('graph.show', [
            'points' => $points,
            'selectedDeviceId' => $selectedDeviceId,
            'selectedDevice' => $selectedDevice,
            'selectedSensor' => $selectedSensor,
            'selectedSensorId' => $selectedSensorId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'devices' => $devices,
            'timeDistribution' => $timeDistribution
            ]);
    }
}
