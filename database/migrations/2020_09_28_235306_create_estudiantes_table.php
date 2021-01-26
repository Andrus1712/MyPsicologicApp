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
            $table->string('tipoIdentificacion')->nullable();
            $table->string('identificacion')->nullable();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->date('fechaNacimiento')->nullable();
            $table->integer('edad')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('sexo')->nullable();
            $table->integer('grupo_id')->unsigned()->nullable();
            $table->integer('acudiente_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('grupo_id')->references('id')->on('grupos');
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
