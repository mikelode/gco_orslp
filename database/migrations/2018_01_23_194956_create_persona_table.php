<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcopersona', function (Blueprint $table) {
            $table->increments('perId');
            $table->string('perDni',10)->nullable();
            $table->string('perFullName',300);
            $table->string('perNames',100)->nullable();
            $table->string('perPaterno',100)->nullable();
            $table->string('perMaterno',100)->nullable();
            $table->string('perOcupation',100);
            $table->date('perBirthday')->nullable();
            $table->string('perEmail',100)->nullable();
            $table->string('perPhone1',20)->nullable();
            $table->string('perPhone2',20)->nullable();
            $table->boolean('perInvalidate')->default(0);
            $table->string('perRegisterBy',20)->nullable();
            $table->datetime('perRegisterAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcoPersona');
    }
}
