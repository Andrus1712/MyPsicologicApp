<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Datos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // DB::table('psicologos')->truncate();
        // DB::table('grupos')->truncate();
        // DB::table('docentes')->truncate();
        // DB::table('estudiantes')->truncate();
        // DB::table('acudientes')->truncate();

        // DB::table('psicologos')->insert([
        //     'tipoIdentificacion' => 'CC',
        //     'identificacion' => '1067854193',
        //     'nombres' => 'Luz Elena',
        //     'apellidos' => 'Ruiz Pertuz',
        //     'correo' => 'lu.ruiz@gmail.com',
        //     'fechaNacimiento' => Carbon::now(),
        //     'telefono' => '3052641846',
        //     'direccion' => 'Monteria',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // $doc1 = DB::table('docentes')->insert([
        //     'tipoIdentificacion' => 'CC',
        //     'identificacion' => '1036541287',
        //     'nombres' => 'Thiago Andres',
        //     'apellidos' => 'Castro Morales',
        //     'correo' => 'tcastro79@gmail.com',
        //     'fechaNacimiento' => Carbon::now(),
        //     'telefono' => '314568741',
        //     'direccion' => 'Monteria',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // $doc2 = DB::table('docentes')->insert([
        //     'tipoIdentificacion' => 'CC',
        //     'identificacion' => '1067854193',
        //     'nombres' => 'Maria Elena',
        //     'apellidos' => 'Ivañes Petro',
        //     'correo' => 'elena_iv12@gmail.com',
        //     'fechaNacimiento' => Carbon::now(),
        //     'telefono' => '3174598564',
        //     'direccion' => 'Monteria',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // $acu1 = DB::table('acudientes')->insert([
        //     'tipoIdentificacion' => 'CC',
        //     'identificacion' => '106541278',
        //     'nombres' => 'Alvaro Jose',
        //     'apellidos' => 'Uribe Gomez',
        //     'correo' => 'u.gomez19@gmail.com',
        //     'fechaNacimiento' => Carbon::now(),
        //     'telefono' => '3042587462',
        //     'direccion' => 'Monteria',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        // $acu2 = DB::table('acudientes')->insert([
        //     'tipoIdentificacion' => 'CC',
        //     'identificacion' => '1067854193',
        //     'nombres' => 'Juan Carlos',
        //     'apellidos' => 'Viloria Bravo',
        //     'correo' => 'jcviloria1@gmail.com',
        //     'fechaNacimiento' => Carbon::now(),
        //     'telefono' => '3014792145',
        //     'direccion' => 'Monteria',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
        

    }
}
