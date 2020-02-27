<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function show(Request $request)
    {
        $selectedSensor = $request->query('sensor', null);
        $startDate = $request->query('start-date', date("Y-m-d",
            mktime(0, 0, 0, date("m"), date("d")-3, date("Y"))));
        $endDate = $request->query('end-date', date("Y-m-d"));

        $constraints = [];

        if ($selectedSensor) {
            $constraints[] = ['sensor', $selectedSensor];
        }

        if ($startDate) {
            $constraints[] = ['added_on', '>=', $startDate];
        }

        if ($endDate) {
            $constraints[] = ['added_on', '<=', $endDate . ' 23:59:59'];
        }

        $sensors = DB::table('events')->select('sensor')->distinct()->get();
        $sensorList = array_map(function($elem) {
            return $elem->sensor; 
        }, $sensors->toArray());

        $events = DB::table('events');
        if(!empty($constraints)) {
            $events = $events->where($constraints);
        }

        $events = $events->orderBy('added_on', 'asc')->get();

        $grouped = $events->mapToGroups(function ($item, $key) {
            return [$item->sensor => $item];
        });

        $graphColor = [];
        $index = 1;
        foreach ($grouped as $key => $value) {
            $graphColor[$key] = $this->HSVtoRGB([(($index++)/count($grouped)), 0.8, 0.8]);
        }

        return View('graph.show', [
            'events' => $grouped,
            'selectedSensor' => $selectedSensor,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'graphColor' => $graphColor,
            'sensorList' => $sensorList
            ]);
    }

    
   
    
    
    private function HSVtoRGB(array $hsv)
    {
        list($H, $S, $V) = $hsv;
        //1
        $H *= 6;
        //2
        $I = floor($H);
        $F = $H - $I;
        //3
        $M = $V * (1 - $S);
        $N = $V * (1 - $S * $F);
        $K = $V * (1 - $S * (1 - $F));
        //4
        switch ($I) {
            case 0:
                list($R, $G, $B) = [$V, $K, $M];
                break;
            case 1:
                list($R, $G, $B) = [$N, $V, $M];
                break;
            case 2:
                list($R, $G, $B) = [$M, $V, $K];
                break;
            case 3:
                list($R, $G, $B) = [$M, $N, $V];
                break;
            case 4:
                list($R, $G, $B) = [$K, $M, $V];
                break;
            case 5:
            case 6: //for when $H=1 is given
                list($R, $G, $B) = [$V, $M, $N];
                break;
        }

        return [floor($R * 255), floor($G * 255), floor($B * 255)];
    }
}
