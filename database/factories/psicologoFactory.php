<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\psicologo;
use Faker\Generator as Faker;

$factory->define(psicologo::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'identificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'correo' => $faker->word,
        'fechaNacimiento' => $faker->word,
        'telefono' => $faker->word,
        'sexo' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
