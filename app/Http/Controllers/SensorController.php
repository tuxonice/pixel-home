<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sensor;

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
        
        return View('sensors.index', ['sensors' => $sensors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hash = rand(1000,9999);
        return View('sensors.create', ['hash' => $hash]);
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
        $sensor->code = $request->code;
        $sensor->name = $request->name;
        $sensor->location = $request->location;
        $sensor->type = $request->type;
        $sensor->hash = $request->hash;
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
        $pushEndPoint = route('event.push', ['hash' => $sensor->hash, 'sensor' => $sensor->code]);
        return View('sensors.edit', ['sensor' => $sensor, 'pushEndPoint' => $pushEndPoint]);
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
        $sensor->code = $request->code;
        $sensor->name = $request->name;
        $sensor->location = $request->location;
        $sensor->type = $request->type;
        $sensor->hash = $request->hash;
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
