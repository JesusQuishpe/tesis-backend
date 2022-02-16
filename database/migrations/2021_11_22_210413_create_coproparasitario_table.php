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
            $table->unsignedBigInteger("id_doc")->nullable()->default(null);
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->string("protozoarios",45)->default('')->default('');
            $table->string("ameba_histolitica",100)->default('');
            $table->string("ameba_coli",100)->default('');
            $table->string("giardia_lmblia",100)->default('');
            $table->string("trichomona_hominis",45)->default('');
            $table->string("chilomastik_mesnile",45)->default('');
            $table->string("helmintos",45)->default('');
            $table->string("trichuris_trichura",45)->default('');
            $table->string("ascaris_lumbricoides",45)->default('');
            $table->string("strongyloides_stecolaries",45)->default('');
            $table->string("oxiuros",45)->default('');
            $table->string("observaciones",200)->default('');
            $table->boolean('atendido')->default(false);
            $table->boolean('eliminado')->default(false);
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
