<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoproparasitarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coproparasitario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cita");
            $table->foreign("id_cita")->references("id")->on("citas");
            $table->unsignedBigInteger("id_doc");
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->string("protozoarios",45);
            $table->string("ameba_histolica",100);
            $table->string("ameba_coli",100);
            $table->string("giardia_lmblia",100);
            $table->string("trichomona_homnis",45);
            $table->string("chilomatik_mes",45);
            $table->string("helmintos",45);
            $table->string("trichuris_trichura",45);
            $table->string("ascaris_lumbicoide",45);
            $table->string("strongyloides_stecolaries",45);
            $table->string("oxiuros",45);
            $table->string("observaciones",200);
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
        Schema::dropIfExists('coproparasitario');
    }
}
