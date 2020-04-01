<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'sensor_id' => 1,
        'temperature' => 17.56,
        'humidity' => 68,
        'flood' => 0,
        'battery' => '3.02',
        'location' => 'Living Room',
        'added_on' => '2020-03-29 12:00:00'
    ];
});
