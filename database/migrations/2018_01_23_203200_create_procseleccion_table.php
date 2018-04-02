<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcseleccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoprocseleccion', function (Blueprint $table) {
            $table->increments('pslId');
            $table->integer('pslProject')->unsigned()->nullable();
            $table->foreign('pslProject')
                    ->references('pryId')
                    ->on('gcoproyecto')
                    ->onDelete('cascade');
            $table->string('pslNomenclatura',100);
            $table->string('pslIdentify',20)->nullable();
            $table->string('pslPathFile',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoprocseleccion');
    }
}
