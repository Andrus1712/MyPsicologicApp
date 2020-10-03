<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\avances;
use Faker\Generator as Faker;

$factory->define(avances::class, function (Faker $faker) {

    return [
        'actividad_id' => $faker->randomDigitNotNull,
        'comportamiento_id' => $faker->randomDigitNotNull,
        'titulo' => $faker->word,
        'estado' => $faker->word,
        'fecha' => $faker->word,
        'documento' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
