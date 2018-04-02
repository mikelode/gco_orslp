<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePspostoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcopspostores', function (Blueprint $table) {
            $table->increments('pstId');
            $table->integer('pstSelectionProc')->unsigned()->nullable();
            $table->foreign('pstSelectionProc')
                    ->references('pslId')
                    ->on('gcoprocseleccion');

            $table->integer('pstJpersona')->unsigned()->nullable();
            $table->foreign('pstJpersona')
                    ->references('prjId')
                    ->on('gcojpersona');

            $table->integer('pstCondition')->unsigned()->nullable();
            $table->foreign('pstCondition')
                    ->references('pscId')
                    ->on('gcopscondicion');

            $table->string('pstPersonType',10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcopspostores');
    }
}
