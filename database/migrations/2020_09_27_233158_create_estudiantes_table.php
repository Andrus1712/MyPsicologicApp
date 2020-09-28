<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstudiantesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipoIdentificacion');
            $table->string('identificacion');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->date('fechaNacimiento');
            $table->string('grado');
            $table->string('telefono');
            $table->string('sexo');
            $table->string('actaAprobacion', 400);
            $table->integer('acudiente_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('acudiente_id')->references('id')->on('acudientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('estudiantes');
    }
}
