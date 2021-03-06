<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            // $table->integer('code')->unique();
            $table->timestamps();
        });

        // Schema::create('user_permission', function (Blueprint $table) {
        //     $table->primary('permission_id', 'user_id');

        //     $table->unsignedInteger('user_id');
        //     $table->unsignedInteger('permission_id');

        //     $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        //     $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        // });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            // $table->primary(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
