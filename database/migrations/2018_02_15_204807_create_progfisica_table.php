<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgfisicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoprogfisica', function (Blueprint $table) {
            $table->increments('prgId');
            $table->integer('prgProject')->unsigned();
            $table->integer('prgBudget')->unsigned();
            $table->foreign('prgBudget')
                    ->references('preId')
                    ->on('gcopresupuesto')
                    ->onDelete('cascade');
            $table->integer('prgExecutor')->unsigned();
            $table->integer('prgNumberVal')->unsigned()->nullable();
            $table->date('prgStartPeriod');
            $table->date('prgEndPeriod');
            $table->string('prgPeriodo',100)->nullable();
            $table->decimal('prgMount',14,5)->nullable();
            $table->decimal('prgPercent',14,5)->nullable();
            $table->decimal('prgAggregate',14,5)->nullable();
            $table->integer('prgBudgetProgress')->unsigned()->nullable();
            $table->decimal('prgMountExec',14,5)->nullable();
            $table->decimal('prgPercentExec',14,5)->nullable();
            $table->decimal('prgAggregateExec',14,5)->nullable();
            $table->string('prgEditNote',1000)->nullable();
            $table->string('prgPathFile',500)->nullable();
            $table->boolean('prgClosed')->default(false)->nullable(); // indicador de valorizacion cerrada o pendiente
            $table->string('prgStatus',20)->nullable(); // normal, suspendido (paralizado), adelantado, atrazado
            $table->boolean('prgPaid')->default(false)->nullable(); // indicador de valorizacion pagada o no

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoprogfisica');
    }
}
