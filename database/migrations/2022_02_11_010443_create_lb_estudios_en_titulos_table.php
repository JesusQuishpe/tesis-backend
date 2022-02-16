<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudiosEnTitulosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('lb_estudios_en_titulos', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('id_exam_tit');
      $table->foreign('id_exam_tit')->references('id')->on('lb_examen_titulos');
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
    Schema::dropIfExists('lb_estudios_en_titulos');
  }
}
