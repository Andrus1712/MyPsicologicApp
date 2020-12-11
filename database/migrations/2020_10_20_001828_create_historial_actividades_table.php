<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_actividades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('actividad_id')->unsigned();
            $table->string('fecha_historial');
            $table->string('descripcion_historial');
            $table->integer('estado_actividad');
            $table->timestamps();

            $table->softDeletes();
            $table->foreign('actividad_id')->references('id')->on('actividades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_actividades');
    }
}
