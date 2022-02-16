<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdontologiaPlanDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odontologia_plan_detalles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_plan_diagnostico');
            $table->foreign('id_plan_diagnostico')->references('id')->on('odontologia_plan_diagnostico');
            $table->unsignedBigInteger('id_plan');
            $table->foreign('id_plan')->references('id')->on('odontologia_planes');
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
        Schema::dropIfExists('odontologia_plan_detalles');
    }
}
