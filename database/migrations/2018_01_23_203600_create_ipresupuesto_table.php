<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoitempresupuesto', function (Blueprint $table) {
            $table->increments('iprId');
            $table->integer('iprBudget')->unsigned();
            $table->foreign('iprBudget')
                    ->references('preId')
                    ->on('gcopresupuesto')
                    ->onDelete('cascade');

            $table->integer('iprOrder')->unsigned()->nullable();
            $table->string('iprCodeItem',20)->nullable();
            $table->string('iprItemGeneral',100)->nullable();
            $table->decimal('iprItemGeneralPrcnt',14,5)->nullable();
            $table->decimal('iprItemGeneralMount',14,5)->nullable();
            $table->boolean('iprItemDisable')->default(0)->nullable();
            $table->string('iprItemDisableDetail',500)->nullable();
            $table->datetime('iprItemUpdateAt')->nullable();
            $table->string('iprItemUpdateDetail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoitempresupuesto');
    }
}
