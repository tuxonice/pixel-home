<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SensorType;

class SensorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sensorTypes = SensorType::paginate(10);
        return View('sensors.types.index', ['sensorTypes' => $sensorTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('sensors.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sensorType = new SensorType;
        $sensorType->name = $request->name;
        $sensorType->save();
        
        return redirect()->route('sensor.type.list');
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
     * @param  SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function edit(SensorType $sensorType)
    {
        return View('sensors.types.edit', ['sensorType' => $sensorType]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  SensorType  $sensorType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SensorType $sensorType)
    {
        $sensorType->name = $request->name;
        $sensorType->update();
        
        return redirect()->route('sensor.type.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SensorType $sensorType
     * @return \Illuminate\Http\Response
     */
    public function destroy(SensorType $sensorType)
    {
        $sensorType->delete();
        
        return redirect()->route('sensor.type.list');
    }
}
