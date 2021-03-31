<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\Device;
use App\Models\Sensor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectedDeviceId = $request->input('device', null);
        $selectedSensorId = $request->input('sensor', null);
        
        $devices = Device::where('active', 1)->orderBy('name', 'ASC')->get();

        if ($selectedDeviceId) {
            $constraints[] = ['device_id', $selectedDeviceId];
        }

        if ($selectedSensorId) {
            $constraints[] = ['sensor_id', $selectedSensorId];
        }

        if ($selectedDeviceId) {
            $selectedDevice = Device::find((int)$selectedDeviceId);
            $dataPoints = Point::where($constraints)->orderBy('added_on', 'DESC')->paginate(15);
        } else {
            $selectedDevice = null;
            $dataPoints = Point::orderBy('added_on', 'DESC')->paginate(15);
        }

        $graphUrl = null;
        if ($selectedSensorId && $selectedDeviceId) {
            $graphUrl = route('graph.show', ['device-id' => $selectedDeviceId, 'sensor-id' => $selectedSensorId]);
        }

        $userTimezone = Auth::user()->timezone;

        $dataPoints->setCollection($dataPoints->getCollection()->map(function ($item, $key) use($userTimezone) {
            $item->added_on = Carbon::createFromFormat('Y-m-d H:i:s', $item->added_on, timezone_open('UTC'))
                ->setTimezone($userTimezone)
                ->toDateTimeString();
            return $item;
        }));
        
        return View('points.index', [
            'dataPoints' => $dataPoints, 
            'devices' => $devices, 
            'selectedDevice' => $selectedDevice,
            'selectedSensorId' => $selectedSensorId,
            'selectedDeviceId' => $selectedDeviceId,
            'graphUrl' => $graphUrl,
            ]
        );
    }

    public function getSensor(Request $request)
    {
        $deviceId = $request->query('device-id', null);
        $device = Device::where('id',$deviceId)->first();

        

        return response()->json($device->sensors);
    }

    public function push(Request $request, $code, $deviceId, $sensorId)
    {
        // /point/push/{code}/{deviceId}/{sensorId}?value=10.4
        $sensorValue = $request->query('value', null);     

        if(is_null($sensorValue)) {
            abort(401);
        }

        $sensor = Sensor::where([['active', 1],['id', (int)$sensorId]])->first();
        if(!$sensor) {
            abort(401);
        }

        $device = Device::where([['active', 1], ['code', $code], ['id', (int)$deviceId]])->first();
        if(!$device) {
            abort(401);
        }

        $deviceSensors = $device->sensors()->get();
        if(!$deviceSensors->contains($sensorId)) {
            abort(401);
        }
        
        $dataPoint = new Point;
        $dataPoint->sensor_id = $sensor->id;
        $dataPoint->device_id = $device->id;
        $dataPoint->value = $sensorValue;
        $dataPoint->added_on = date("Y-m-d H:i:s");
        $dataPoint->save();
    }
}
