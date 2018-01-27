<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Equiprof::class, function (Faker $faker) {
    return [
        'prfPerson' => $faker->numberBetween(1,10),
        'prfJob' => $faker->randomElement(['residente','supervisor']),
        'prfUejecutora' => $faker->numberBetween(1,3),
    ];
});
