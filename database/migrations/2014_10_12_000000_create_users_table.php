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
        Schema::create('gcousuario', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('tusId');
            $table->string('tusNickName', 20);
            $table->string('password', 60);
            $table->string('tusDni', 10)->nullable();
            $table->string('tusFullName', 300);
            $table->string('tusNames',100);
            $table->string('tusPaterno',100);
            $table->string('tusMaterno',100);
            $table->string('tusRole',50)->nullable();
            $table->integer('tusProject')->unsigned();
            $table->string('tusJob',100)->nullable();
            $table->string('tusEmail',250)->nullable();
            $table->string('tusPhone',100)->nullable();
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
        Schema::dropIfExists('gcousuario');
    }
}
