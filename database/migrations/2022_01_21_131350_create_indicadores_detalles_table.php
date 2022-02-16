<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ind');
            $table->foreign('id_ind')->references('id')->on('indicadores');
            $table->integer('num_pieza1')->default(0);
            $table->integer('num_pieza2')->default(0);
            $table->integer('num_pieza3')->default(0);
            $table->integer('num_placa')->default(0);
            $table->integer('num_calc')->default(0);
            $table->integer('num_gin')->default(0);
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
        Schema::dropIfExists('indicadores_detalles');
    }
}
