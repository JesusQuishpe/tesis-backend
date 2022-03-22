<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbExamenesSelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_examenes_sel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_captura');
            $table->foreign('id_captura')->references('id')->on('lb_captura_resultados');
            $table->unsignedBigInteger("id_examen");
            $table->foreign('id_examen')->references('id')->on('lb_examenes');
            $table->boolean('estado')->default(false);
            $table->integer('numEstudios')->default(0);
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
        Schema::dropIfExists('lb_examenes_sel');
    }
}
