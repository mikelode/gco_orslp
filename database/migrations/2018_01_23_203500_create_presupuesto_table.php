<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcopresupuesto', function (Blueprint $table) {
            $table->increments('preId');
            $table->integer('preProject')->unsigned();
            $table->foreign('preProject')
                    ->references('pryId')
                    ->on('gcoproyecto')
                    ->onDelete('cascade');

            $table->integer('preOrder')->unsigned()->nullable();
            $table->string('preCodeItem',20)->nullable();
            $table->string('preItemGeneral',100)->nullable();
            $table->decimal('preItemGeneralPrcnt',14,5)->nullable();
            $table->decimal('preItemGeneralMount',14,2)->nullable();
            $table->boolean('preItemDisable')->default(0)->nullable();
            $table->string('preItemDisableDetail',500)->nullable();
            $table->datetime('preItemUpdateAt')->nullable();
            $table->string('preItemUpdateDetail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcopresupuesto');
    }
}
