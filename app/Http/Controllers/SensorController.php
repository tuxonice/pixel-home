<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{
    public function show()
    {
        $events = DB::table('events')->orderBy('added_on', 'desc')->paginate(20);
        return View('sensors.show', ['events' => $events]);
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
