<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoroles', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('trolId');

            $table->integer('trolIdUser')->unsigned();
            $table->foreign('trolIdUser')
                    ->references('tusId')
                    ->on('gcousuario')
                    ->onDelete('cascade');

            $table->integer('trolIdSyst')->unsigned();
            $table->foreign('trolIdSyst')
                    ->references('tsysId')
                    ->on('gcosistema')
                    ->onDelete('cascade');


            $table->boolean('trolEnable');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoroles');
    }
}
