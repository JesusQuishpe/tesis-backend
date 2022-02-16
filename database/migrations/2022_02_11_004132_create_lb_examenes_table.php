<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbExamenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_examenes', function (Blueprint $table) {
            $table->id();
            //$table->unsignedBigInteger('id_estudio')->nullable()->default(null);
            //$table->foreign('id_estudio')->references('id')->on('lb_estudios');
            //$table->unsignedBigInteger('id_tipo');
            //$table->foreign('id_tipo')->references('id')->on('lb_tipo_examen');
            $table->string('nombre');
            $table->float('costo')->default(0);
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
        Schema::dropIfExists('lb_examenes');
    }
}
