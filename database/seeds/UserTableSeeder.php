<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('users')->truncate();

        $user = DB::table('users')->insert([
            'name' => 'andres',
            'email' => 'andres@app.com',
            'password' => Hash::make('andres123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        $docente = DB::table('docentes')->insert([
            'tipoIdentificacion' => 'CC',
            'identificacion' => '12342344223',
            'nombres' => 'Docente',
            'apellidos' => 'Uno',
            'correo' => 'docente1@gmail.com',
            'fechaNacimiento' => '1967-12-11',
            'telefono' => '31443525252',
            'direccion' => 'Monteria',
        ]);

        $userD = DB::table('users')->insert([
            'name' => 'Docente Uno',
            'email' => 'docente1@gmail.com',
            'password' => Hash::make('docente'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $acudiente = DB::table('acudientes')->insert([
            'tipoIdentificacion' => 'CC',
            'identificacion' => '10782544323',
            'nombres' => 'Acudiente',
            'apellidos' => 'Uno',
            'correo' => 'acudeinte1@gmail.com',
            'fechaNacimiento' => '1967-12-11',
            'telefono' => '31443525252',
            'direccion' => 'Monteria',
        ]);

        $userA = DB::table('users')->insert([
            'name' => 'Acudeinte Uno',
            'email' => 'acudiente1@gmail.com',
            'password' => Hash::make('acudiente'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $psicooriantador = DB::table('psicologos')->insert([
            'tipoIdentificacion' => 'CC',
            'identificacion' => '10790989563',
            'nombres' => 'psicooriantador',
            'apellidos' => 'Uno',
            'correo' => 'psicooriantador1@gmail.com',
            'fechaNacimiento' => '1967-12-11',
            'telefono' => '31443525252',
            'direccion' => 'Monteria',
        ]);

        $userP = DB::table('users')->insert([
            'name' => 'psicooriantador Uno',
            'email' => 'psicooriantador1@gmail.com',
            'password' => Hash::make('psicooriantador'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $grupo = DB::table('grupos')->insert([
            'grado' => 8,
            'curso' => 'A',
            'docente_id' => 1
        ]);

        $estudiante = DB::table('estudiantes')->insert([
            'tipoIdentificacion' => 'TI',
            'identificacion' => '10782544323',
            'nombres' => 'Estudiante',
            'apellidos' => 'Uno',
            'correo' => 'estudiante1@gmail.com',
            'sexo' => 'M',
            'fechaNacimiento' => '2000-01-11',
            'telefono' => '31443525252',
            'edad' => '20',
            'acudiente_id' => 1,
            'grupo_id' => 1,
        ]);

        $userE = DB::table('users')->insert([
            'name' => 'Estudiante Uno',
            'email' => 'estudiante1@gmail.com',
            'password' => Hash::make('estudiante'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}