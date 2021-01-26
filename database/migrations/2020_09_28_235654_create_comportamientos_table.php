<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComportamientosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comportamientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('estudiante_id')->unsigned()->nullable();
            $table->integer('tipo_comportamiento_id')->nullable()->unsigned();
            $table->string('titulo')->nullable();
            $table->string('descripcion')->nullable();
            $table->date('fecha')->nullable();
            $table->string('emisor')->nullable();
            $table->string('multimedia', 5000)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('estudiante_id')
            ->references('id')->on('estudiantes');
            $table->foreign('tipo_comportamiento_id')
            ->references('id')->on('tipo_comportamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comportamientos');
    }
}
