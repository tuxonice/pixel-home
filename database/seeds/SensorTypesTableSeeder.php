<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorTypesTableSeeder extends Seeder
{
    use DataMapping;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $records = [];
        foreach ($this->sensorTypes as $sensorType) {
            $records[] = ['name' => $sensorType['name']];
        }
        
        DB::table('sensor_types')->insert($records);
    }
}
