<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUejecutoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcouejecutora', function (Blueprint $table) {
            $table->increments('ejeId');
            $table->string('ejePersonType',10); // natural o jurídica
            $table->string('ejeRegistType',10)->nullable(); // RUC o DNI u OTRO
            $table->string('ejeRegistNumber',12)->nullable(); // Numero de RUC o DNI
            $table->string('ejeBusiName',1000)->nullable();
            $table->string('ejeAcronym',100)->nullable();
            $table->string('ejeLegalRepDni',10)->nullable();
            $table->string('ejeLegalRepName',100)->nullable();
            $table->string('ejeLegalRepPaterno',100)->nullable();
            $table->string('ejeLegalRepMaterno',100)->nullable();
            $table->string('ejeInvalidate')->default(0);
            $table->string('ejeRegisterBy',20)->nullable();
            $table->datetime('ejeRegisterAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoUejecutora');
    }
}
