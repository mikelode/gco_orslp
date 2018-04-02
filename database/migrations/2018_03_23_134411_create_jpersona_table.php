<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJpersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gcojpersona', function (Blueprint $table) {
            $table->increments('prjId');
            $table->string('prjRegistType',10)->nullable(); // RUC o DNI u OTRO
            $table->string('prjRegistNumber',12)->nullable(); // Numero de RUC o DNI
            $table->string('prjBusiName',1000)->nullable();
            $table->string('prjAcronym',100)->nullable();
            $table->string('prjLegalRepDni',10)->nullable();
            $table->string('prjLegalRepName',100)->nullable();
            $table->string('prjLegalRepPaterno',100)->nullable();
            $table->string('prjLegalRepMaterno',100)->nullable();
            $table->string('prjEaddress',500)->nullable();
            $table->string('prjPaddress',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gcojpersona');
    }
}
