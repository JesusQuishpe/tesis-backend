<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_cita',11);
            $table->string('hora_cita',8);
            $table->string('cedula_cita',10);
            $table->string('area',25);
            $table->decimal('valor',10,2);
            $table->string('factura_cita',15)->nullable()->default(null);
            $table->string('estado_cita',20)->nullable()->default(null);
            $table->unsignedBigInteger('id_paciente');
            $table->foreign('id_paciente')->references('id')->on('pacientes');
            $table->string('estadisticas',15)->nullable()->default(null);
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
        Schema::dropIfExists('citas');
    }
}
