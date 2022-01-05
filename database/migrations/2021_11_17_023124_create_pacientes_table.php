<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('fecha',22);
            $table->string('cedula',10)->unique();
            $table->string('apellidos',50);
            $table->string('nombres',50);
            $table->string('nombre_completo',100);
            $table->string('fecha_nacimiento',12);
            $table->string('sexo',10);
            $table->string('telefono',20);
            $table->string('domicilio',150);
            $table->string('provincia',50);
            $table->string('ciudad',50);
            $table->string('historial',10)->nullable();
            $table->string('fecha_historial',10)->nullable();
            $table->string('estadisticas',1)->nullable();
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
        Schema::dropIfExists('pacientes');
    }
}
