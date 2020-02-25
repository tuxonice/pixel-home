<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $selectedSensor = $request->input('sensor', null);
        
        $sensorList = DB::table('events')->select('sensors.id','sensors.name')
        ->join('sensors', 'events.sensor_id', '=', 'sensors.id')
        ->distinct()->orderBy('sensors.name', 'asc')->get();
        
        $events = DB::table('events');
        if($selectedSensor) {
            $events = $events->where('events.sensor_id',$selectedSensor);
        }
        $events = $events->join('sensors', 'events.sensor_id', '=', 'sensors.id')
            ->select('events.*', 'sensors.name', 'sensors.type')
            ->orderBy('events.added_on', 'desc')->paginate(20);
        
        return View('events.show', [
            'events' => $events, 
            'selectedSensor' => $selectedSensor,
            'sensorList' => $sensorList
            ]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $hash)
    {
        // /event/store/{hash}/index.php?sensor=1&hum=79&temp=17.00
        // /event/store/{hash}/index.php?sensor=2&temp=17.62&flood=0&batV=2.98

        $sensorCode = $request->query('sensor', null);
        if(is_null($sensorCode)) {
            abort(401);
        }

        if ($hash !== env('HASH_KEY')) {
            abort(401);
        }
        
        $sensor = Sensor::where([['hash', $hash], ['code', $sensorCode]])->first();
        if(!$sensor) {
            abort(401);
        }
        
        $temperature = $request->query('temp', null);
        $flood = $request->query('flood', null);
        $humidity = $request->query('hum', null);
        $battery = $request->query('batV', null);
        
        $event = new Event;
        $event->sensor = $sensor->code; //TODO: remove when delete the database column 
        $event->sensor_id = $sensor->id;
        $event->temperature = $temperature;
        $event->humidity = $humidity;
        $event->flood = $flood;
        $event->battery = $battery;

        $event->save();
        
        if($flood) {
            Mail::to(env('MAIL_TO'))->send(new SensorAlert($sensor));
        }
    }

}
