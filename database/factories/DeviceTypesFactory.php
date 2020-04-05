<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeviceTypes;
use Faker\Generator as Faker;

$factory->define(DeviceTypes::class, function (Faker $faker) {
    return [
        'name' => $faker->word;
    ];
});
