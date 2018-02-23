<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvancepresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcoavancepres', function (Blueprint $table) {
            $table->increments('aprId');
            $table->integer('aprExecutor')->unsigned();
            $table->integer('aprResident')->unsigned();
            $table->integer('aprSupervisor')->unsigned();
            $table->integer('aprProject')->unsigned();
            $table->integer('aprProgFisica')->unsigned();
            $table->string('aprPeriod',50);
            $table->date('aprStartDate');
            $table->date('aprEndDate');
            $table->string('aprWorkBook',300)->nullable();
            $table->boolean('aprInvalidate')->default(0);
            $table->string('aprInvalidateDetail',200)->nullable();
            $table->datetime('aprInvalidateAt')->nullable();
            $table->string('aprInvalidateBy',20)->nullable();
            $table->datetime('aprRegisterAt')->nullable();
            $table->string('aprRegisterBy',20)->nullable();
            $table->datetime('aprUpdateAt')->nullable();
            $table->string('aprUpdateBy',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoavancepres');
    }
}
