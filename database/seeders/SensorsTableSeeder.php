<?php

namespace Database\Seeders;

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
        $records = [
            [
                'name' => 'Temperature',
                'unit' => 'Celsius degrees',
                'unit_symbol' => 'ºC',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Humidity',
                'unit' => 'Percentage',
                'unit_symbol' => '%',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Current',
                'unit' => 'Ampere',
                'unit_symbol' => 'A',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Voltage',
                'unit' => 'Volt',
                'unit_symbol' => 'V',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Rotation',
                'unit' => 'rpm',
                'unit_symbol' => 'rpm',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Wind Speed',
                'unit' => 'meter per second',
                'unit_symbol' => 'm/s',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Energy',
                'unit' => 'Kilowatt-hour',
                'unit_symbol' => 'Kwh',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Power',
                'unit' => 'Watt',
                'unit_symbol' => 'W',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'Resistence',
                'unit' => 'Ohm',
                'unit_symbol' => 'Ohm',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
            [
                'name' => 'CO2',
                'unit' => 'Parts-per-million',
                'unit_symbol' => 'ppm',
                'active' => rand(1, 100) > 20 ? 1 : 0,
            ],
        ];

        DB::table('sensors')->insert($records);
    }
}
