<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $sensors = Sensor::paginate(10);

        return View('partials.sensor.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $hash = rand(1000, 9999);

        return View('partials.sensor.create', ['hash' => $hash]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $sensor = new Sensor;
        $sensor->name = $request->name;
        $sensor->unit = $request->unit;
        $sensor->unit_symbol = $request->unit_symbol;
        $sensor->active = $request->active === null ? 0 : 1;
        $sensor->save();

        return redirect()->route('sensor.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sensor $sensor
     * @return View
     */
    public function edit(Sensor $sensor): View
    {
        return View('partials.sensor.edit', ['sensor' => $sensor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Sensor $sensor
     * @return RedirectResponse
     */
    public function update(Request $request, Sensor $sensor): RedirectResponse
    {
        $sensor->name = $request->name;
        $sensor->unit = $request->unit;
        $sensor->unit_symbol = $request->unit_symbol;
        $sensor->active = $request->active === null ? 0 : 1;
        $sensor->update();

        return redirect()->route('sensor.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sensor $sensor
     * @return RedirectResponse
     */
    public function destroy(Sensor $sensor): RedirectResponse
    {
        $sensor->delete();

        return redirect()->route('sensor.list');
    }
}
