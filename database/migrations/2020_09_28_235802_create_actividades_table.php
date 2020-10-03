<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActividadesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->date('fecha');
            $table->string('descripcion');
            $table->integer('estado');
            $table->integer('comportamiento_id')->unsigned();
            $table->integer('tipo_comportamiento_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('comportamiento_id')->references('id')->on('comportamientos');
            $table->foreign('tipo_comportamiento_id')->references('id')->on('tipo_comportamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actividades');
    }
}
