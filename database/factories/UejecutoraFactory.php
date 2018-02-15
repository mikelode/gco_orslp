<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Uejecutora::class, function (Faker $faker) {

	$paterno = $faker->lastName;
	$materno = $faker->lastName;
	$nombres = $faker->firstName;

	return [
                'ejePersonType' => $faker->randomElement(['PN','PJ']),
                'ejeRegistType' => $faker->randomElement(['DNI','RUC']),
                'ejeRegistNumber' => '10'.$faker->dni.$faker->randomDigitNotNull,
                'ejeBusiName' => $faker->company,
                'ejeAcronym' => $faker->companySuffix,
                'ejeLegalRepDni' => $faker->dni,
                'ejeLegalRepName' => $nombres,
                'ejeLegalRepPaterno' => $paterno,
                'ejeLegalRepMaterno' => $materno,
	];
});
