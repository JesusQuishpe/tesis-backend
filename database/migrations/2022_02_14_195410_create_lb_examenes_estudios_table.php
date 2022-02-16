<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbExamenesEstudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_examenes_estudios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_examen');
            $table->foreign('id_examen')->references('id')->on('lb_examenes');
            $table->unsignedBigInteger('id_estudio');
            $table->foreign('id_estudio')->references('id')->on('lb_estudios');
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
        Schema::dropIfExists('lb_examenes_estudios');
    }
}
