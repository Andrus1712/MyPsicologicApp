<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePsicologosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psicologos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoIdentificacion');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->date('fechaNacimiento');
            $table->string('telefono');
            $table->string('direccion');
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('psicologos');
    }
}
