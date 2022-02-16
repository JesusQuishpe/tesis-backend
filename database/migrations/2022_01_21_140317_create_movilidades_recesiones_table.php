<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovilidadesRecesionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movilidades_recesiones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontograma');
            $table->foreign('id_odontograma')->references('id')->on('odontograma');
            $table->string('tipo',100);
            $table->string('valor',1);
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
        Schema::dropIfExists('movilidades_recesiones');
    }
}
