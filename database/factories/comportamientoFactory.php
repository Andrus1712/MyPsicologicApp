<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\comportamiento;
use Faker\Generator as Faker;

$factory->define(comportamiento::class, function (Faker $faker) {

    return [
        'tipo_id' => $faker->randomDigitNotNull,
        'estudiante_id' => $faker->randomDigitNotNull,
        'descripcion' => $faker->word,
        'titulo' => $faker->word,
        'fecha' => $faker->word,
        'emisor' => $faker->word,
        'multimedia' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
