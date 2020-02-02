<?php

use Illuminate\Database\Seeder;

class importSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = 0;
        $path = storage_path('app/sensors.csv');
        if (($handle = fopen($path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, "|")) !== false) {
                $row++;
                if($row === 1) {
                    continue;
                } 
                
                $addedOn = trim($data[0]);
                $sensor = trim($data[1]);
                $temperature = trim($data[2]);
                $flood = trim($data[3]) === '-' ? null : trim($data[3]);
                $humidity = trim($data[4]) === '--' ? null : trim($data[4]);
                $battery = trim($data[5]) === '-' ? null : trim($data[5]);
                
                DB::table('events')->insert(
                    [
                        'sensor' => $sensor, 
                        'temperature' => $temperature,
                        'humidity' => $humidity,
                        'flood' => $flood,
                        'battery' => $battery,
                        'added_on' => $addedOn,
                    ]
                );
            }
            fclose($handle);
        }
    }
}
