<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvanceresumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoavanceresumen', function (Blueprint $table) {
            $table->increments('avrId');
            $table->integer('avrBudgetProgress')->unsigned();
            $table->foreign('avrBudgetProgress')
                    ->references('aprId')
                    ->on('gcoavancepres');

            $table->string('avrCodeItem',20)->nullable();
            $table->decimal('avrMountBa',14,2)->default(0.00)->nullable();
            $table->decimal('avrPercentBa',14,2)->nullable();
            $table->decimal('avrMountCv',14,2)->default(0.00)->nullable();
            $table->decimal('avrPercentCv',14,2)->nullable();
            $table->decimal('avrMountCa',14,2)->default(0.00)->nullable();
            $table->decimal('avrPercentCa',14,2)->nullable();
            $table->decimal('avrMountBv',14,2)->default(0.00)->nullable();
            $table->decimal('avrPercentBv',14,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoavanceresumen');
    }
}
