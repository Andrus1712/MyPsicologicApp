<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\estudiante;
use Faker\Generator as Faker;

$factory->define(estudiante::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'identificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'correo' => $faker->word,
        'fechaNacimiento' => $faker->word,
        'grado' => $faker->word,
        'telefono' => $faker->word,
        'sexo' => $faker->word,
        'actaAprobacion' => $faker->word,
        'acudiente_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
