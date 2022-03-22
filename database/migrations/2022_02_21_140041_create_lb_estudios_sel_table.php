<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudiosSelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_estudios_sel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_examen_sel');
            $table->foreign('id_examen_sel')->references('id')->on('lb_examenes_sel');
            $table->unsignedBigInteger('id_estudio');
            $table->foreign('id_estudio')->references('id')->on('lb_estudios');
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
        Schema::dropIfExists('lb_estudios_sel_temp');
    }
}
