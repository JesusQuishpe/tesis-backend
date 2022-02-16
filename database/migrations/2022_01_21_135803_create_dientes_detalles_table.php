<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDientesDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dientes_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontograma');
            $table->foreign('id_odontograma')->references('id')->on('odontograma');
            $table->unsignedBigInteger('id_diente');
            $table->foreign('id_diente')->references('id')->on('dientes');
            $table->unsignedBigInteger('id_simbologia');
            $table->foreign('id_simbologia')->references('id')->on('odontologia_simbologias');
            $table->string('diente_left',50);
            $table->string('diente_top',50);
            $table->string('diente_right',50);
            $table->string('diente_bottom',50);
            $table->string('diente_center',50);
            $table->integer('pos');
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
        Schema::dropIfExists('dientes_detalles');
    }
}
