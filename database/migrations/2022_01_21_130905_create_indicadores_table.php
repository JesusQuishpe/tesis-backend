<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontologia');
            $table->foreign('id_odontologia')->references('id')->on('odontologias');
            $table->boolean('enf_period');
            $table->boolean('mal_oclu');
            $table->boolean('fluorosis');
            $table->float('total_placa')->default(0);
            $table->float('total_calc')->default(0);
            $table->float('total_gin')->default(0);
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
        Schema::dropIfExists('indicadores');
    }
}
