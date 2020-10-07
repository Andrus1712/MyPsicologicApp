<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\modelo_seguimiento;
use Faker\Generator as Faker;

$factory->define(modelo_seguimiento::class, function (Faker $faker) {

    return [
        'fecha' => $faker->word,
        'nombre' => $faker->word,
        'estamento' => $faker->word,
        'medio_comunicacion' => $faker->word,
        'clasificacion_caso_presentado' => $faker->word,
        'descripcion' => $faker->word,
        'solucion' => $faker->word,
        'remitido' => $faker->word,
        'estado' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
