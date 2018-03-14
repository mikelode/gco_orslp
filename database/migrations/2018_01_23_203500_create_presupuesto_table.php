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
            $table->integer('preType')->unsigned(); // inicial = 1, adicional = 2, mayores metrados = 3, deductivos = 4.
            $table->foreign('preType')
                    ->references('tprId')
                    ->on('gcotpresupuesto');
            $table->string('preNote',1000)->nullable();
            $table->string('preName',100)->nullable();
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
