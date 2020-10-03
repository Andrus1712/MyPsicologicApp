<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\grupo_profesor;
use Faker\Generator as Faker;

$factory->define(grupo_profesor::class, function (Faker $faker) {

    return [
        'grupo_id' => $faker->randomDigitNotNull,
        'docente_id' => $faker->randomDigitNotNull,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
