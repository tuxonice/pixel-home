<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\Device;
use App\Models\Sensor;

class PointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectedDevice = $request->input('device', null);
        
        $devices = Device::where('active', 1)->orderBy('name', 'ASC')->get();
        if($selectedDevice) {
            $device = Device::find((int)$selectedDevice);
            $dataPoints = Point::where('device_id', $device->id)->orderBy('added_on', 'DESC')->paginate(15);
        } else {
            $dataPoints = Point::orderBy('added_on', 'DESC')->paginate(15);
        }
        
        return View('points.index', [
            'dataPoints' => $dataPoints, 
            'devices' => $devices, 
            'selectedDevice' => $selectedDevice
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
