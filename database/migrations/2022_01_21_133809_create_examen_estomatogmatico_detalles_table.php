<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenEstomatogmaticoDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_estomatogmatico_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_exa');
            $table->foreign('id_exa')->references('id')->on('examen_estomatogmatico');
            $table->unsignedBigInteger('id_pat');
            $table->foreign('id_pat')->references('id')->on('patologias');
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
        Schema::dropIfExists('examen_estomatogmatico_detalles');
    }
}
