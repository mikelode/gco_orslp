<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpresupuestoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcotpresupuesto', function (Blueprint $table) {
            $table->increments('tprId');
            $table->string('tprDescription');
            $table->boolean('tprHaveValorization'); // 0 = no requirece valorizacion, 1 = si requiere valorizacion
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcotpresupuesto');
    }
}
