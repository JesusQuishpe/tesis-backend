<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTratamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontologia');
            $table->foreign('id_odontologia')->references('id')->on('odontologias');
            $table->integer('sesion');
            $table->dateTime('fecha_tratamiento');
            $table->string('diag_complica',300);
            $table->string('procedimientos',300);
            $table->string('prescripciones',300);
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
        Schema::dropIfExists('tratamientos');
    }
}
