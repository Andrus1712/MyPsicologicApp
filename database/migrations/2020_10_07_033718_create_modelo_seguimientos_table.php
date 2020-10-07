<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModeloSeguimientosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modelo_seguimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->string('nombre');
            $table->string('estamento');
            $table->string('medio_comunicacion');
            $table->string('clasificacion_caso_presentado');
            $table->string('descripcion');
            $table->string('solucion');
            $table->string('remitido');
            $table->string('estado');
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
        Schema::drop('modelo_seguimientos');
    }
}
