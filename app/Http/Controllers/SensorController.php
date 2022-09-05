<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sensors = Sensor::paginate(10);

        return View('partials.sensor.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hash = rand(1000, 9999);

        return View('partials.sensor.create', ['hash' => $hash]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor)
    {
        return View('partials.sensor.edit', ['sensor' => $sensor]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
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
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        $sensor->delete();

        return redirect()->route('sensor.list');
    }
}
