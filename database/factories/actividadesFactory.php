<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\actividades;
use Faker\Generator as Faker;

$factory->define(actividades::class, function (Faker $faker) {

    return [
        'titulo' => $faker->word,
        'fecha' => $faker->word,
        'descripcion' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
