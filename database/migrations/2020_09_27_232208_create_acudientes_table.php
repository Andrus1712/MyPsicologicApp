<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAcudientesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acudientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoIdentificacion');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fechaNacimiento');
            $table->string('correo');
            $table->string('direccion', 255);
            $table->string('telefono', 10);
            $table->string('sexo');
            $table->string('photo', 400);
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
        Schema::drop('acudientes');
    }
}
