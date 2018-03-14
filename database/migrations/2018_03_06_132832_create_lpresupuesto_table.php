<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcolpresupuesto', function (Blueprint $table) {
            $table->increments('lprId');
            $table->decimal('lprOrderItem')->unsigned();
            $table->string('lprCodeItem',20)->nullable();
            $table->string('lprDescriptionItem');
            $table->boolean('lprIsProportion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcolpresupuesto');
    }
}
