<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateEventData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ph:update-event-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update data from events table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sensorList = DB::table('events')->select('sensor_id')->distinct()->get();
        
        foreach($sensorList as $sensor) {
            $eventList = DB::table('events')->select('events.*','sensors.type')
            ->join('sensors', 'events.sensor_id', '=', 'sensors.id')
            ->where('events.sensor_id', $sensor->sensor_id)
            ->orderBy('events.added_on', 'desc')->get()->toArray();

            $elementCount = count($eventList);

            for ($i=0;$i<$elementCount-1;$i++) {
                $currentRecord = $eventList[$i];
                $previousRecord = $eventList[$i+1];
                $currentRecord->diff_temperature = $currentRecord->temperature - $previousRecord->temperature;
                $currentRecord->diff_time = Carbon::parse($currentRecord->added_on)->diffInMinutes($previousRecord->added_on);
                if($currentRecord->type === 'HT') {
                    $currentRecord->diff_humidity = $currentRecord->humidity - $previousRecord->humidity;
                    $this->updateHtRecord($currentRecord);
                    continue;
                }

                $this->updateFloodRecord($currentRecord);
            }

        }
    }
    
    private function updateHtRecord($record)
    {
        DB::table('events')
            ->where('id', $record->id)
            ->update(
                [
                    'diff_temperature' => $record->diff_temperature,
                    'diff_humidity' => $record->diff_humidity,
                    'diff_time' => $record->diff_time,
                ]
            );
    }
    
    private function updateFloodRecord($record)
    {
        DB::table('events')
            ->where('id', $record->id)
            ->update(
                [
                    'diff_temperature' => $record->diff_temperature,
                    'diff_time' => $record->diff_time,
                ]
            );
    }
}
