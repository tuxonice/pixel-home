<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Devices;
use Faker\Generator as Faker;

$factory->define(Devices::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'location' => $faker->word,
        'type_id' => 1,
        'code' => 'ABC123',
        'active' => 1,
    ];
});
