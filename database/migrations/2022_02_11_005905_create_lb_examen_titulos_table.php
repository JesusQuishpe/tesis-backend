<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbExamenTitulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_examen_titulos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_titulo');
            $table->foreign('id_titulo')->references('id')->on('lb_titulos');
            $table->unsignedBigInteger('id_examen');
            $table->foreign('id_examen')->references('id')->on('lb_examenes');
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
        Schema::dropIfExists('lb_examen_titulos');
    }
}
