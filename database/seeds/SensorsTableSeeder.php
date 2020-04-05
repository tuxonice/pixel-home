<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensors')->insert([
            [
                'sensor_type_id' => 1,
                'device_id' => 1,
                'name' => 'Temperature Sensor',
                'unit' => 'Temperature',
                'unit_symbol' => 'ºC',
                'active' => 1,
            ],
            [
                'sensor_type_id' => 2,
                'device_id' => 2,
                'name' => 'Humidity Sensor',
                'unit' => 'Humidity',
                'unit_symbol' => '%',
                'active' => 1,
            ],
            [
                'sensor_type_id' => 3,
                'device_id' => 3,
                'name' => 'CO2 Sensor',
                'unit' => 'CO2',
                'unit_symbol' => 'ppp',
                'active' => 1,
            ],
            
        ]);
    }
}
