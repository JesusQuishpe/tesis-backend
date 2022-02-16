<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntecedentesDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antecedentes_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_anf');
            $table->foreign('id_anf')->references('id')->on('antecedentes_familiares');
            $table->unsignedBigInteger('id_ant');
            $table->foreign('id_ant')->references('id')->on('antecedentes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antecedentes_detalles');
    }
}
