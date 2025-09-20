<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $devices = Device::paginate(15);

        return View('partials.device.index', ['devices' => $devices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $code = rand(1000, 9999);
        $sensors = Sensor::where('active', 1)->get();

        return View('partials.device.create', ['code' => $code, 'sensors' => $sensors]);
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $device = new Device;
        $device->name = $request->name;
        $device->location = $request->location;
        $device->code = $request->code;
        $device->active = $request->active;
        $device->save();
        $device->sensors()->attach($request->sensor_id);

        return redirect()->route('device.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Device $device
     * @return View
     */
    public function edit(Device $device): View
    {
        $sensors = Sensor::where('active', 1)->get();

        return View('partials.device.edit', ['device' => $device, 'sensors' => $sensors]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function update(Request $request, Device $device): RedirectResponse
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
     * @param Request $request
     * @param Device $device
     * @return RedirectResponse
     */
    public function deleteSensor(Request $request, Device $device): RedirectResponse
    {
        $device->sensors()->detach($request->sensor_id);

        return redirect()->route('device.edit', ['device' => $device]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return RedirectResponse
     */
    public function destroy(Device $device): RedirectResponse
    {
        $device->sensors()->detach();
        $device->delete();

        return redirect()->route('device.list');
    }
}
