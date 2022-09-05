<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function show(Request $request)
    {
        $selectedDeviceId = $request->query('device-id', null);
        $selectedSensorId = $request->query('sensor-id', null);
        $startDate = $request->query('start-date', date('Y-m-d H:i',
            mktime(0, 0, 0, date('m'), date('d') - 3, date('Y'))));
        $endDate = $request->query('end-date', date('Y-m-d H:i',
            mktime(23, 59, 59, date('m'), date('d'), date('Y'))));

        $devices = Device::get();

        if ($selectedDeviceId) {
            $selectedDevice = Device::find((int) $selectedDeviceId);
        } else {
            $selectedDevice = null;
        }

        if ($selectedSensorId) {
            $selectedSensor = Sensor::find((int) $selectedSensorId);
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

        $jsonData = json_encode(array_map(function ($elem) {
            return ['date' => $elem->added_on, 'value' => $elem->value];
        }, $points->toArray()));

        return View('partials.graph.show', [
            'points' => json_encode($jsonData),
            'selectedDeviceId' => $selectedDeviceId,
            'selectedDevice' => $selectedDevice,
            'selectedSensor' => $selectedSensor,
            'selectedSensorId' => $selectedSensorId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'devices' => $devices,
            'minValue' => $minValue,
            'maxValue' => $maxValue,
            'averageValue' => $averageValue,
        ]);
    }
}
