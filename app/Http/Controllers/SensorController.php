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
        //dd($request->all());
        
        $startDate = '2020-01-25 00:00:00';
        $endDate = '2020-02-02 00:00:00';
        
        $events = DB::table('events')->where([
            ['sensor', 'HT01'],
            ['added_on', '>=', $startDate],
            ['added_on', '<=', $endDate]
            ])->orderBy('added_on', 'asc')->limit(20)->get();

        $ht01 = array_map(function($elem) {
            return ['x' => $elem->added_on ,'y' => $elem->temperature];
        }, $events->toArray());

        $events = DB::table('events')->where([
            ['sensor', 'FL01'],
            ['added_on', '>=', $startDate],
            ['added_on', '<=', $endDate]
            ])->orderBy('added_on', 'asc')->limit(20)->get();

        $fl01 = array_map(function($elem) {
            return ['x' => $elem->added_on ,'y' => $elem->temperature];
        }, $events->toArray());
        
        $events = DB::table('events')->where([
            ['sensor', 'FL02'],
            ['added_on', '>=', $startDate],
            ['added_on', '<=', $endDate]
            ])->orderBy('added_on', 'asc')->limit(20)->get();

        $fl02 = array_map(function($elem) {
            return ['x' => $elem->added_on ,'y' => $elem->temperature];
        }, $events->toArray());

        
        
        return View('sensors.graph', [
            'ht01' => json_encode($ht01),
            'fl01' => json_encode($fl01),
            'fl02' => json_encode($fl02),
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
