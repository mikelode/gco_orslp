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
            $table->string('pryViabilityResolution',100)->nullable();
            $table->date('pryDateResolution')->nullable();
            $table->string('pryExeMode',50);
            $table->integer('pryExeUnit')->unsigned()->nullable();
            $table->foreign('pryExeUnit')
                    ->references('ejeId')
                    ->on('gcouejecutora')
                    ->onDelete('cascade');
            $table->date('pryDateAgree')->nullable();
            $table->integer('pryMonthTerm')->unsigned()->nullable();
            $table->integer('pryDaysTerm')->unsigned()->nullable();
            $table->date('pryStartDateExe')->nullable();
            $table->date('pryEndDateExe')->nullable();
            $table->integer('pryBaseBudget')->unsigned()->nullable();
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
        Schema::dropIfExists('gcoproyecto');
    }
}
