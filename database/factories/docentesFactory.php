<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\docentes;
use Faker\Generator as Faker;

$factory->define(docentes::class, function (Faker $faker) {

    return [
        'tipoIdentificacion' => $faker->word,
        'nombres' => $faker->word,
        'apellidos' => $faker->word,
        'identificacion' => $faker->word,
        'correo' => $faker->word,
        'telefono' => $faker->word,
        'foto' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
