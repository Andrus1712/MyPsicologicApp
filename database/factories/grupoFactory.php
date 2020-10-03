<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\grupo;
use Faker\Generator as Faker;

$factory->define(grupo::class, function (Faker $faker) {

    return [
        'nombre' => $faker->word,
        'curso' => $faker->word,
        'docente_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
