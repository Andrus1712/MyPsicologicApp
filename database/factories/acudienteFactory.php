<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\acudiente;
use Faker\Generator as Faker;

$factory->define(acudiente::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'identificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'fechaNacimiento' => $faker->word,
        'correo' => $faker->word,
        'direccion' => $faker->word,
        'telefono' => $faker->word,
        'sexo' => $faker->word,
        'photo' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
