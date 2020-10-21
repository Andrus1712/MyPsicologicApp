<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ver
        DB::table('permissions')->insert([
            'name' => 'ver estudiantes',
            'slug' => 'v1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver docentes',
            'slug' => 'v2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver acudientes',
            'slug' => 'v3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver psicologos',
            'slug' => 'v4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver comportamientos',
            'slug' => 'v5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver actividades',
            'slug' => 'v6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver avances',
            'slug' => 'v7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver cursos',
            'slug' => 'v8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //Editar
        DB::table('permissions')->insert([
            'name' => 'editar estudiantes',
            'slug' => 'e1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar docentes',
            'slug' => 'e2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar acudientes',
            'slug' => 'e3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar psicologos',
            'slug' => 'e4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar comportamientos',
            'slug' => 'e5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'elitar actividades',
            'slug' => 'e6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar avances',
            'slug' => 'e7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar cursos',
            'slug' => 'e8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //Eliminar
        DB::table('permissions')->insert([
            'name' => 'elimnar estudiantes',
            'slug' => 'd1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar docentes',
            'slug' => 'd2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar acudientes',
            'slug' => 'd3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar psicologos',
            'slug' => 'd4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar comportamientos',
            'slug' => 'd5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar actividades',
            'slug' => 'd6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar avances',
            'slug' => 'd7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar cursos',
            'slug' => 'd8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //crear
        DB::table('permissions')->insert([
            'name' => 'crear estudiantes',
            'slug' => 'c1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear docentes',
            'slug' => 'c2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear acudientes',
            'slug' => 'c3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear psicologos',
            'slug' => 'c4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear comportamientos',
            'slug' => 'c5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear actividades',
            'slug' => 'c6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear avances',
            'slug' => 'c7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear cursos',
            'slug' => 'c8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //especiales
        DB::table('permissions')->insert([
            'name' => 'crear usuarios',
            'slug' => 'x1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar usuarios',
            'slug' => 'x2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar usuarios',
            'slug' => 'x3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver usuarios',
            'slug' => 'x4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear roles',
            'slug' => 'x5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar roles',
            'slug' => 'x6',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar roles',
            'slug' => 'x7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver roles',
            'slug' => 'x8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'generar reportes',
            'slug' => 'x9',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'Modulo seguimientos',
            'slug' => 'x10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}