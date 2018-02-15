<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvancedetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoavancedet', function (Blueprint $table) {
            $table->increments('avcId');
            $table->integer('avcBudgetProgress')->unsigned();
            $table->foreign('avcBudgetProgress')
                    ->references('aprId')
                    ->on('gcoavancepres');

            $table->integer('avcPartidaId')->unsigned();
            $table->foreign('avcPartidaId')
                    ->references('parId')
                    ->on('gcopartidas');

            $table->string('avcItem',20);
            $table->decimal('avcMeteredBa',14,2)->default(0.00)->nullable();
            $table->decimal('avcMountBa',14,2)->default(0.00)->nullable();
            $table->decimal('avcPercentBa',14,2)->default(0.00)->nullable();
            $table->decimal('avcMeteredCv',14,2)->default(0.00)->nullable();
            $table->decimal('avcMountCv',14,2)->default(0.00)->nullable();
            $table->decimal('avcPercentCv',14,2)->default(0.00)->nullable();
            $table->decimal('avcMeteredCa',14,2)->default(0.00)->nullable();
            $table->decimal('avcMountCa',14,2)->default(0.00)->nullable();
            $table->decimal('avcPercentCa',14,2)->default(0.00)->nullable();
            $table->decimal('avcMeteredBv',14,2)->default(0.00)->nullable();
            $table->decimal('avcMountBv',14,2)->default(0.00)->nullable();
            $table->decimal('avcPercentBv',14,2)->default(0.00)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoavancedet');
    }
}
