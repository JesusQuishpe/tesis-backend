<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudiosSelDetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_estudios_sel_det', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudio_padre_sel');
            $table->foreign('id_estudio_padre_sel')->references('id')->on('lb_estudios_sel');
            $table->unsignedBigInteger('id_estudio_hijo');
            $table->foreign('id_estudio_hijo')->references('id')->on('lb_estudios');
            $table->string('resultado_texto')->nullable()->default(null);
            $table->float('resultado_numerico')->nullable()->default(null);
            $table->string('observacion',300)->nullable()->default('');
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
        Schema::dropIfExists('lb_estudios_sel_det_temp');
    }
}
