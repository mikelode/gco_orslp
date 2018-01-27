<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Persona::class, function (Faker $faker) {

	$paterno = $faker->lastName;
	$materno = $faker->lastName;
	$nombres = $faker->firstName;
	$ocup = $faker->randomElement(['Ing','Sr','CPC','Lic','Mg','Dr']);

    return [
        'perDni' => $faker->dni,
        'perFullName' => $ocup.' '.$nombres.' '.$paterno.' '.$materno,
        'perNames' => $nombres,
        'perPaterno' => $paterno,
        'perMaterno' => $materno,
        'perOcupation' => $ocup,
        'perBirthday' => $faker->date($format = 'Y-m-d', $max = '1980-1-15'),
        'perEmail' => $faker->unique()->safeEmail,
        'perPhone1' => $faker->phoneNumber,
        'perPhone2' => $faker->phoneNumber,
    ];
});
