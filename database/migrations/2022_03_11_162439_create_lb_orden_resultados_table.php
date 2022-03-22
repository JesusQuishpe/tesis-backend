<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbOrdenResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_orden_resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_orden_prueba');
            $table->foreign('id_orden_prueba')->references('id')->on('lb_orden_pruebas');
            $table->string('resultado_string',100);
            $table->float('resultado_numerico');
            $table->string('observacion',300);
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
        Schema::dropIfExists('lb_orden_resultados');
    }
}
