<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sensor;
use Faker\Generator as Faker;

$factory->define(Sensor::class, function (Faker $faker) {
    return [
        'code' => 'HT01',
        'name' => 'HT01',
        'location' => 'Office',
        'type' => 'HT',
        'hash' => '12345',
    ];
});
