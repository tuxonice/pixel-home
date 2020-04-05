<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SensorTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sensor_types')->insert([
            ['name' => 'Temperature'],
            ['name' => 'Humidity'],
            ['name' => 'CO2'],
            ['name' => 'Voltage'],
            ['name' => 'Current'],
            ['name' => 'Wind'],
            ['name' => 'Resistence'],
        ]);
    }
}
