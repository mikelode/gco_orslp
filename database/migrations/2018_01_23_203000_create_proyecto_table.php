<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoproyecto', function (Blueprint $table) {
            $table->increments('pryId');
            $table->string('prySnip',10)->nullable();
            $table->string('pryUnifiedCode',10)->nullable();
            $table->string('pryDenomination',500)->nullable();
            $table->string('pryShortDenomination',200)->nullable();
            $table->date('pryViabilityDatePip')->nullable();
            $table->date('pryViabilityDateSD')->nullable();
            $table->string('pryViabilityResolution',100)->nullable();
            $table->string('pryExeMode',50);
            $table->integer('pryExeUnit')->unsigned()->nullable();
            $table->foreign('pryExeUnit')
                    ->references('ejeId')
                    ->on('gcoUejecutora')
                    ->onDelete('cascade');

            $table->boolean('pryInvalidate')->default(0);
            $table->string('pryInvalidateDetail',200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoProyecto');
    }
}
