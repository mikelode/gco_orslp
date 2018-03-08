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
            $table->foreign('prgProject')
                    ->references('pryId')
                    ->on('gcoproyecto');
            $table->integer('prgNumberVal')->unsigned()->nullable();
            $table->string('prgPeriodo',100)->nullable();
            $table->decimal('prgMount',14,5)->nullable();
            $table->decimal('prgPercent',14,5)->nullable();
            $table->decimal('prgAggregate',14,5)->nullable();
            $table->integer('prgBudgetProgress')->unsigned()->nullable();
            $table->decimal('prgMountExec',14,5)->nullable();
            $table->decimal('prgPercentExec',14,5)->nullable();
            $table->decimal('prgAggregateExec',14,5)->nullable();
            $table->string('prgEditNote',1000)->nullable();
            $table->boolean('prgClosed')->default(false)->nullable();

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
