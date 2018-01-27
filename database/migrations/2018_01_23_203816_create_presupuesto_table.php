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

            $table->string('preItem',20);
            $table->string('preUnit',10);
            $table->decimal('preMetered',14,2)->default(0.00);
            $table->decimal('prePrice',14,2)->default(0.00);
            $table->decimal('prePartial',14,2);
            $table->boolean('preItemDisable')->nullable();
            $table->string('preItemDisableItem',100);
            $table->datetime('preItemUpdateAt');
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
