<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcopartidas', function (Blueprint $table) {
            $table->increments('parId');
            $table->integer('parProject')->unsigned();
            $table->foreign('parProject')
                    ->references('pryId')
                    ->on('gcoproyecto');

            $table->integer('parLevel')->unsigned();
            $table->string('parItem',20)->nullable();
            $table->string('parDescription',1000)->nullable();
            $table->string('parUnit',10)->nullable();
            $table->decimal('parMetered',14,5)->default(0.00)->nullable();
            $table->decimal('parPrice',14,5)->default(0.00)->nullable();
            $table->decimal('parPartial',14,5)->nullable();
            $table->boolean('parItemDisable')->default(0)->nullable();
            $table->string('parItemDisableDetail',500)->nullable();
            $table->datetime('parItemUpdateAt')->nullable();
            $table->string('parItemUpdateDetail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcopartidas');
    }
}
