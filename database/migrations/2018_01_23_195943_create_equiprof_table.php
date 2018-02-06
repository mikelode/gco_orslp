<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEquiprofTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoequiprof', function (Blueprint $table) {
            $table->increments('prfId');
            $table->integer('prfPerson')->unsigned();
            $table->foreign('prfPerson')
                    ->references('perId')
                    ->on('gcoPersona')
                    ->onDelete('cascade');

            $table->string('prfJob',30)->nullable();
            $table->boolean('prfDisable')->default(0);
            $table->string('prfDetailDisable', 200)->nullable();
            $table->integer('prfUejecutora')->unsigned();
            $table->foreign('prfUejecutora')
                    ->references('ejeId')
                    ->on('gcoUejecutora')
                    ->onDelete('cascade');

            $table->boolean('prfInvalidate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoEquiprof');
    }
}
