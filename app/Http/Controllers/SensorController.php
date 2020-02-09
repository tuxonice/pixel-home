<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    public function show(Request $request)
    {
        $sensorName = $request->input('sensor', null);

        $events = DB::table('events');
        if($sensorName) {
            $events = $events->where('sensor',$sensorName);
        }
        $events = $events->orderBy('added_on', 'desc')->paginate(20);

        return View('sensors.show', ['events' => $events, 'sensorName' => $sensorName]);
    }

    public function graph(Request $request)
    {
        $sensor = $request->query('sensor', null);
        $startDate = $request->query('start-date', date("Y-m-d",
            mktime(0, 0, 0, date("m"), date("d")-2, date("Y"))));
        $endDate = $request->query('end-date', date("Y-m-d"));

        $constraints = [];

        if ($sensor) {
            $constraints[] = ['sensor', $sensor];
        }

        if ($startDate) {
            $constraints[] = ['added_on', '>=', $startDate];
        }

        if ($endDate) {
            $constraints[] = ['added_on', '<=', $endDate];
        }

        $events = DB::table('events');
        if(!empty($constraints)) {
            $events = $events->where($constraints);
        }

        $events = $events->orderBy('added_on', 'asc')->get();

        $grouped = $events->mapToGroups(function ($item, $key) {
            return [$item->sensor => $item];
        });

        return View('sensors.graph', [
            'events' => $grouped,
            'sensor' => $sensor,
            'startDate' => $startDate,
            'endDate' => $endDate
            ]);
    }

    
    public function push(Request $request, $hash)
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
        
    }
}
