<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DataPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->associateDeviceSensor();
        
        $deviceSensorList = DB::table('device_sensor')->get();
        
        foreach($deviceSensorList as $deviceSensor) {
            $record = [];
            for($i=0;$i<=50;$i++) {
                $dataPointTime = Carbon::now();
                $dataPointTime->subDays(rand(1,60))->subHours(rand(0,23))->subMinutes(rand(0,59))->subSeconds(rand(0,59));
                
                $record[] = [
                'device_id' => $deviceSensor->device_id,
                'sensor_id' => $deviceSensor->sensor_id,
                'value' => rand(1,1000) / 10,
                'added_on' => $dataPointTime->toDateTimeString()
                ];
            }
            
            DB::table('points')->insert($record);
        }
    }

    protected function associateDeviceSensor()
    {
        $deviceList = DB::table('devices')->get();
        $sensorList = DB::table('sensors')->get();
        foreach($deviceList as $device) {
            $records = [];
            $sensorCount = rand(1,3);
            $sensors = $sensorList->random($sensorCount)->all();
            
            foreach($sensors as $sensor) {
                $records[] = [
                    'device_id' => $device->id,
                    'sensor_id' => $sensor->id,
                ];
            }
            DB::table('device_sensor')->insert($records);
        }
    }
}
