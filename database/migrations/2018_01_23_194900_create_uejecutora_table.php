<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUejecutoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcouejecutora', function (Blueprint $table) {
            $table->increments('ejeId');
            $table->integer('ejePostor')->unsigned();
            $table->integer('ejeProject')->unsigned();
            $table->foreign('ejeProject')
                    ->references('pryId')
                    ->on('gcoproyecto')
                    ->onDelete('cascade');
            $table->string('ejeMode',50)->nullable();
            $table->string('ejeSisContract',50)->nullable();
            $table->decimal('ejeMountContract',14,5)->default(0)->nullable();
            $table->decimal('ejeMountRefValue',14,5)->default(0)->nullable();
            $table->decimal('ejeRelationFactor',14,5)->nullable();
            $table->date('ejeDateAgree')->nullable();
            $table->integer('ejeMonthTerm')->unsigned()->nullable();
            $table->integer('ejeDaysTerm')->unsigned()->nullable();
            $table->date('ejeStartDate')->nullable();
            $table->date('ejeEndDate')->nullable();
            $table->string('ejeInvalidate')->default(0);
            $table->string('ejeRegisterBy',20)->nullable();
            $table->datetime('ejeRegisterAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcouejecutora');
    }
}
