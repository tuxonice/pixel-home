<?php

namespace App\Http\Controllers;

use App\Event;
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
        
        $sensors = DB::table('events')->select('sensor')->distinct()->get();
        $sensorList = array_map(function($elem) {
            return $elem->sensor; 
        }, $sensors->toArray());

        $events = DB::table('events');
        if($selectedSensor) {
            $events = $events->where('sensor',$selectedSensor);
        }
        $events = $events->orderBy('added_on', 'desc')->paginate(20);

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
        // /index.php?sensor=1&hum=79&temp=17.00
        // /index.php?sensor=2&temp=17.62&flood=0&batV=2.98

        if ($hash !== env('HASH_KEY')) {
            abort(401);
        }

        $sensor = $request->query('sensor', null);
        if(is_null($sensor)) {
            return;
        }
        $temperature = $request->query('temp', null);
        $flood = $request->query('flood', null);
        $humidity = $request->query('hum', null);
        $battery = $request->query('batV', null);
        
        DB::table('events')->insert(
            [
                'sensor' => $sensor, 
                'temperature' => $temperature,
                'humidity' => $humidity,
                'flood' => $flood,
                'battery' => $battery
            ]
        );
        
        if($flood) {
            Mail::to(env('MAIL_TO'))->send(new SensorAlert($sensor));
        }
    }

}
