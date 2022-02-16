<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudiosDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_estudios_det', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudio_padre');
            $table->foreign('id_estudio_padre')->references('id')->on('lb_estudios');
            $table->unsignedBigInteger('id_estudio_hijo');
            $table->foreign('id_estudio_hijo')->references('id')->on('lb_estudios');
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
        Schema::dropIfExists('lb_estudios_det');
    }
}
