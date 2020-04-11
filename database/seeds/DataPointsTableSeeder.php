<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DataPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get sensor list
        $sensorList = DB::table('sensors')->get();
        
        
        foreach($sensorList as $sensor) {
            $record = [];
            for($i=0;$i<=50;$i++) {
                $dataPointTime = Carbon::now();
                $dataPointTime->subDays(rand(1,60))->subHours(0,23)->subMinutes(0,59)->subSeconds(0,59);
                
                $record[] = [
                'sensor_id' => $sensor->id,
                'value' => rand(1,100),
                'added_on' => $dataPointTime->toDateTimeString()
                ];
            }
            
            DB::table('data_points')->insert($record);
        }
    }
}
