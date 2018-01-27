<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoUsuario', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('tusId');
            $table->string('tusNickName', 20);
            $table->string('tusPassword', 60);
            $table->string('tusDni', 10)->nullable();
            $table->string('tusFullName', 300);
            $table->string('tusNames',100);
            $table->string('tusPaterno',100);
            $table->string('tusMaterno',100);
            $table->string('tusRegisterBy',50)->nullable();
            $table->dateTime('tusRegisterAt')->nullable();
            $table->boolean('tusState')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoUsuario');
    }
}
