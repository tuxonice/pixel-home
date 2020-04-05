<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SensorTypes;
use Faker\Generator as Faker;

$factory->define(SensorTypes::class, function (Faker $faker) {
    return [
        'name' => $faker->word;
    ];
});
