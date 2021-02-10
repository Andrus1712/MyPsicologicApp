<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGruposTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grado'); 
            $table->string('curso');
            $table->integer('docente_id')->unsigned()->unique()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('docente_id')->references('id')->on('docentes');
            $table->unique(['grado', 'curso']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grupos');
    }
}
