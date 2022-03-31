<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbCapturaResultadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_captura_resultados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_captura');
            $table->foreign('id_captura')->references('id')->on('lb_capturas');
            $table->unsignedBigInteger('id_prueba');
            $table->foreign('id_prueba')->references('id')->on('lb_pruebas');
            $table->string('resultado_string',100)->nullable();
            $table->float('resultado_numerico')->nullable();
            $table->string('observaciones',300)->nullable();
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
        Schema::dropIfExists('lb_captura_resultados');
    }
}
