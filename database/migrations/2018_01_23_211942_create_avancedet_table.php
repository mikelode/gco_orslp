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
            $table->string('avcItem',20);
            $table->decimal('avcFisico',14,2)->default(0.00);
            $table->decimal('avcFinanciero',14,2)->default(0.00);
            $table->decimal('avcFisicoAggregate',14,2)->default(0.00);
            $table->decimal('avcFinancieroAggregate',14,2)->default(0.00);
            $table->decimal('avcSaldoFisico',14,2);
            $table->decimal('avcSaldoFinanciero',14,2);
            $table->decimal('avcPercentFisico',14,2);
            $table->decimal('avcPercentFinanciero',14,2);
            $table->integer('avcBudgetProgress')->unsigned();
            $table->foreign('avcBudgetProgress')
                    ->references('aprId')
                    ->on('gcoAvancepres')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoAvancedet');
    }
}
