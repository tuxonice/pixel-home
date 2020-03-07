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

$factory->state(Sensor::class, 'flood', function ($faker) {
    return [
        'code' => 'FL01',
        'name' => 'FL01',
        'location' => 'WC',
        'type' => 'FLOOD',
        'hash' => '12345',
    ];
});
