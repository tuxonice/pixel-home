<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorsTableSeeder extends Seeder
{
    use DataMapping;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Read Device list
        $devices = DB::table('devices')->select('id')->get();
        
        $deviceList = array_map(function($elem) { return $elem->id; }, $devices->toArray());
        $records = [];
        foreach ($deviceList as $deviceId) {
            $sensorCountForDevice = rand(1,4);
            $sensorTypeKeys = array_rand($this->sensorTypes, $sensorCountForDevice);
            
            $sensorTypeKeys = is_array($sensorTypeKeys) ? $sensorTypeKeys : [$sensorTypeKeys];
            
            for ($i=0; $i < count($sensorTypeKeys); $i++) {
                
                $sensorTypeKey = $sensorTypeKeys[$i];
                $sensorTypeName = $this->sensorTypes[$sensorTypeKey]['name'];
                $sensorTypeUnits = $this->sensorTypes[$sensorTypeKey]['units'][array_rand($this->sensorTypes[$sensorTypeKey]['units'])];
                
                $records[] = [
                    'sensor_type_id' => 1,
                    'device_id' => $deviceId,
                    'name' => $sensorTypeName.' Sensor',
                    'unit' => $sensorTypeUnits[0],
                    'unit_symbol' => $sensorTypeUnits[1],
                    'active' => rand(1,100) > 20 ? 1 : 0,
                ];
            }
            
        }
        
        DB::table('sensors')->insert($records);
    }
}
