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

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('permissions')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('role_user')->truncate();

        //ver
        DB::table('permissions')->insert([
            'name' => 'ver estudiantes',
            'slug' => 'show.estudiantes',
            // 'code' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver docentes',
            'slug' => 'show.docentes',
            // 'code' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver acudientes',
            'slug' => 'show.acudientes',
            // 'code' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver psicologos',
            'slug' => 'show.psicologos',
            // 'code' => 4,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver comportamientos',
            'slug' => 'show.comportamientos',
            // 'code' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver actividades',
            'slug' => 'show.actividades',
            // 'code' => 6,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver avances',
            'slug' => 'show.avances',
            // 'code' => 7,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver cursos',
            'slug' => 'show.cursos',
            // 'code' => 8,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //Editar
        DB::table('permissions')->insert([
            'name' => 'editar estudiantes',
            'slug' => 'edit.estudiantes',
            // 'code' => 9,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar docentes',
            'slug' => 'edit.docentes',
            // 'code' => 10,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar acudientes',
            'slug' => 'edit.acudientes',
            // 'code' => 11,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar psicologos',
            'slug' => 'edit.psicologos',
            // 'code' => 12,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar comportamientos',
            'slug' => 'edit.comportamientos',
            // 'code' => 13,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar actividades',
            'slug' => 'edit.actividades',
            // 'code' => 14,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar avances',
            'slug' => 'edit.avances',
            // 'code' => 15,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar cursos',
            'slug' => 'edit.cursos',
            // 'code' => 16,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //Eliminar
        DB::table('permissions')->insert([
            'name' => 'elimnar estudiantes',
            'slug' => 'delete.estudiantes',
            // 'code' => 17,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar docentes',
            'slug' => 'delete.docentes',
            // 'code' => 18,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar acudientes',
            'slug' => 'delete.acudientes',
            // 'code' => 19,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar psicologos',
            'slug' => 'delete.psicologos',
            // 'code' => 20,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar comportamientos',
            'slug' => 'delete.comportamientos',
            // 'code' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar actividades',
            'slug' => 'delete.actividades',
            // 'code' => 22,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar avances',
            'slug' => 'delete.avances',
            // 'code' => 23,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar cursos',
            'slug' => 'delete.cursos',
            // 'code' => 24,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //crear
        DB::table('permissions')->insert([
            'name' => 'crear estudiantes',
            'slug' => 'create.estudiantes',
            // 'code' => 25,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear docentes',
            'slug' => 'create.docentes',
            // 'code' => 26,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear acudientes',
            'slug' => 'create.acudientes',
            // 'code' => 27,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear psicologos',
            'slug' => 'create.psicologos',
            // 'code' => 28,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear comportamientos',
            'slug' => 'create.comportamientos',
            // 'code' => 29,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear actividades',
            'slug' => 'create.actividades',
            // 'code' => 30,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear avances',
            'slug' => 'create.avances',
            // 'code' => 31,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear cursos',
            'slug' => 'create.cursos',
            // 'code' => 32,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //Segumeinto
        DB::table('permissions')->insert([
            'name' => 'generar reportes',
            'slug' => 'make.reportes',
            // 'code' => 41,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'Modulo seguimientos',
            'slug' => 'modulo.seguimiento',
            // 'code' => 42,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        //especiales del sistema
        DB::table('permissions')->insert([
            'name' => 'crear usuarios',
            'slug' => 'create.user',
            // 'code' => 33,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar usuarios',
            'slug' => 'edit.user',
            // 'code' => 34,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar usuarios',
            'slug' => 'delete.user',
            // 'code' => 35,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver usuarios',
            'slug' => 'show.user',
            // 'code' => 36,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'crear roles',
            'slug' => 'create.roles',
            // 'code' => 37,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'editar roles',
            'slug' => 'edit.roles',
            // 'code' => 38,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'eliminar roles',
            'slug' => 'delete.roles',
            // 'code' => 39,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'ver roles',
            'slug' => 'show.roles',
            // 'code' => 40,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'tipos de comportamientos',
            'slug' => 'tipos.comportamientos',
            // 'code' => 40,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 5,
        ]);

        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 1,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 2,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 3,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 4,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 5,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 6,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 7,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 8,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 9,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 10,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 11,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 12,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 13,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 14,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 15,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 16,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 17,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 18,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 19,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 20,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 21,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 22,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 23,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 24,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 25,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 26,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 27,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 28,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 29,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 30,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 31,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 32,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 33,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 34,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 35,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 36,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 37,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 38,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 39,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 40,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 41,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 42,
        ]);
        DB::table('permission_role')->insert([
            'role_id' => 5,
            'permission_id' => 43,
        ]);

        
    }
}