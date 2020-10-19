<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('roles')->truncate();

        DB::table('roles')->insert([
            'name' => 'Psicoorientador',
            'descripcion' => 'Es la perosna encargada de llevar a cabo los procesos de seeguimiento y monitereo de los estudiantes; Encargado de asignar citas; Edicion y eliminacion de datos',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'Estudiante',
            'descripcion' => 'Encargado de realizar las activiades; Puede ver actividades y sus avances',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'Docente',
            'descripcion' => 'Encargado de reportar comportamientos; Puede ver comportamientos',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('roles')->insert([
            'name' => 'Acudiente',
            'descripcion' => 'Encargado de reportar comportamientos; Puede ver comportamientos y actividades de los estudiantes acudidos',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
