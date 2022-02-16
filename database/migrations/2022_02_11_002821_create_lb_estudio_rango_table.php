<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbEstudioRangoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_estudio_rango', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_estudio');
            $table->foreign('id_estudio')->references('id')->on('lb_estudios');
            $table->float('de')->default(0);
            $table->float('hasta')->default(0);
            $table->string('interpretacion');
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
        Schema::dropIfExists('lb_estudio_rango');
    }
}
