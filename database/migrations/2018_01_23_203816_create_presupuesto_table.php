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
        Schema::create('gcoPresupuesto', function (Blueprint $table) {
            $table->increments('preId');
            $table->integer('preProject')->unsigned();
            $table->foreign('preProject')
                    ->references('pryId')
                    ->on('gcoProyecto')
                    ->onDelete('cascade');

            $table->integer('preLevel')->unsigned();
            $table->string('preItem',20)->nullable();
            $table->string('preDescription',1000)->nullable();
            $table->string('preUnit',10)->nullable();
            $table->decimal('preMetered',14,2)->default(0.00)->nullable();
            $table->decimal('prePrice',14,2)->default(0.00)->nullable();
            $table->decimal('prePartial',14,2)->nullable();
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
        Schema::dropIfExists('gcoPresupuesto');
    }
}
