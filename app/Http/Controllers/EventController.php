<?php

namespace App\Http\Controllers;

use App\Event;
use App\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventAlert;
use Carbon\Carbon;

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
        $selectedLocation = $request->input('location', null);
        
        $sensorList = DB::table('events')->select('sensors.id','sensors.name')
        ->join('sensors', 'events.sensor_id', '=', 'sensors.id')
        ->distinct()->orderBy('sensors.name', 'asc')->get();
        
        $locationList = DB::table('events')->select('events.location AS name')
        ->where('events.location', '!=', 'null')->distinct()->get();
        
        $events = DB::table('events');
        if($selectedSensor) {
            $events = $events->where('events.sensor_id',$selectedSensor);
        }
        
        if($selectedLocation) {
            $events = $events->where('events.location',$selectedLocation);
        }
        
        $events = $events->join('sensors', 'events.sensor_id', '=', 'sensors.id')
            ->select('events.*', 'sensors.name', 'sensors.type')
            ->orderBy('events.added_on', 'desc')->paginate(20);

        $events = $this->processDiffs($events);
        
        return View('events.show', [
            'events' => $events, 
            'selectedSensor' => $selectedSensor,
            'selectedLocation' => $selectedLocation,
            'sensorList' => $sensorList,
            'locationList' => $locationList
            ]);
    }

    private function processDiffs($events)
    {
        $sensors = [];
        foreach(array_reverse($events->items()) as &$event) {
            if(!isset($sensors[$event->sensor_id])) {
                $sensors[$event->sensor_id]['temperature'] = $event->temperature;
                $sensors[$event->sensor_id]['time'] = $event->added_on;
                if($event->type == 'HT') {
                    $sensors[$event->sensor_id]['humidity'] = $event->humidity; 
                }
            }
            
            $event->diffTemperature = $event->temperature - $sensors[$event->sensor_id]['temperature'];
            $sensors[$event->sensor_id]['temperature'] = $event->temperature;
            
            $event->diffTime = Carbon::parse($event->added_on)->diffForHumans(Carbon::parse($sensors[$event->sensor_id]['time']),['parts' => 2]);
            $event->diffTime = str_replace([' after',' before'], '', $event->diffTime);
            $sensors[$event->sensor_id]['time'] = $event->added_on;
            
            if($event->type == 'HT') {
                $event->diffHumidity = $event->humidity - $sensors[$event->sensor_id]['humidity'];
                $sensors[$event->sensor_id]['humidity'] = $event->humidity; 
            }
               
        }
        
        return $events;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function push(Request $request, $hash)
    {
        // /event/push/{hash}/index.php?sensor=1&hum=79&temp=17.00
        // /event/push/{hash}/index.php?sensor=2&temp=17.62&flood=0&batV=2.98

        $sensorCode = $request->query('sensor', null);
        if(is_null($sensorCode)) {
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
        $event->location = $sensor->location;
        $event->added_on = date("Y-m-d H:i:s");
        $event->save();
        
        if($flood) {
            Mail::to(env('MAIL_TO'))->send(new EventAlert($event));
        }
    }

}
