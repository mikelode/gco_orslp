<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmplazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoamplazo', function (Blueprint $table) {
            $table->increments('ampId');
            $table->integer('ampProject')->unsigned();
            $table->integer('ampBudget')->unsigned();
            $table->integer('ampSchedulePeriod')->unsigned();
            $table->foreign('ampSchedulePeriod')
                    ->references('prgId')
                    ->on('gcoprogfisica');

            $table->integer('ampCaso')->unsigned();
            $table->foreign('ampCaso')
                    ->references('camId')
                    ->on('gcocasoampliacion');

            $table->string('ampNote')->nullable();
            $table->date('ampStartExterm');
            $table->date('ampEndExterm');
            $table->integer('ampDaysTerm');
            $table->date('ampEndExe');
            $table->string('ampPathFile',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoamplazo');
    }
}
