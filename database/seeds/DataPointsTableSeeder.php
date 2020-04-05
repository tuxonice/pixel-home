<?php

use Illuminate\Database\Seeder;

class DataPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('data_points')->insert([
            [
                'sensor_id' => 1,
                'value' => 20.5
            ],
            [
                'sensor_id' => 2,
                'value' => 65
            ],
            [
                'sensor_id' => 3,
                'value' => 450
            ],
        ]);
    }
}
