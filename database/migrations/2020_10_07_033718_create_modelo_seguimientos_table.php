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
            $table->date('fecha')->nullable();
            $table->string('nombre')->nullable();
            $table->string('estamento')->nullable();
            $table->string('medio_comunicacion')->nullable();
            $table->string('clasificacion_caso_presentado')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('solucion')->nullable();
            $table->string('remitido')->nullable();
            $table->string('estado')->nullable();
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
