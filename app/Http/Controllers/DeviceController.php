<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $devices = Device::paginate(15);

        return View('partials.device.index', ['devices' => $devices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $code = rand(1000, 9999);
        $sensors = Sensor::where('active', 1)->get();

        return View('partials.device.create', ['code' => $code, 'sensors' => $sensors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $device = new Device;
        $device->name = $request->name;
        $device->location = $request->location;
        $device->code = $request->code;
        $device->active = $request->active;
        $device->save();
        $device->sensors()->attach($request->sensor_id);

        return redirect()->route('device.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not Used
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        $sensors = Sensor::where('active', 1)->get();

        return View('partials.device.edit', ['device' => $device, 'sensors' => $sensors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        $device->name = $request->name;
        $device->location = $request->location;
        $device->code = $request->code;
        $device->active = $request->has('active') ? 1 : 0;
        if ((int) $request->sensor_id) {
            $device->sensors()->attach((int) $request->sensor_id);
        }

        $device->update();

        return redirect()->route('device.edit', ['device' => $device]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Device  $device
     * @return \Illuminate\Http\Response
     */
    public function deleteSensor(Request $request, Device $device)
    {
        $device->sensors()->detach($request->sensor_id);

        return redirect()->route('device.edit', ['device' => $device]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        $device->sensors()->detach();
        $device->delete();

        return redirect()->route('device.list');
    }
}
