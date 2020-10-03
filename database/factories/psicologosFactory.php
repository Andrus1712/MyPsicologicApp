<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\psicologos;
use Faker\Generator as Faker;

$factory->define(psicologos::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'identificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'telefono' => $faker->word,
        'correo' => $faker->word,
        'fechaNacimiento' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
