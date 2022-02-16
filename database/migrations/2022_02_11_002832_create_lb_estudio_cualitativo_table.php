<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudioCualitativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_estudio_cualitativo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudio');
            $table->foreign('id_estudio')->references('id')->on('lb_estudios');
            $table->string('valor');
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
        Schema::dropIfExists('lb_estudio_cualitativo');
    }
}
