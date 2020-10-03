<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\estudiantes;
use Faker\Generator as Faker;

$factory->define(estudiantes::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'identificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'edad' => $faker->randomDigitNotNull,
        'telefono' => $faker->word,
        'correo' => $faker->word,
        'fechaNacimiento' => $faker->word,
        'acudiente_id' => $faker->randomDigitNotNull,
        'grupo_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
