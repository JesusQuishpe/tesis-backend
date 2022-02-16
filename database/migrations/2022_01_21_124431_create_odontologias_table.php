<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontologias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_enf');
            $table->foreign('id_enf')->references('id')->on('enfermeria');
            $table->dateTime('fecha_consulta');
            $table->string('seleccion_edad');
            $table->string('motivo_consulta',500);
            $table->string('enfermedad_problema',500);
            $table->boolean('atendido')->default(false);
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
        Schema::dropIfExists('odontologias');
    }
}
