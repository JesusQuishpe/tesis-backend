<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenOrinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_orina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cita");
            $table->foreign("id_cita")->references("id")->on("citas");
            $table->unsignedBigInteger("id_doc");
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->string("color",45);
            $table->string("olor",45);
            $table->string("sedimento",45);
            $table->float("ph");
            $table->float("densidad");
            $table->string("leucocituria",45);
            $table->string("nitritos",45);
            $table->string("albumina",45);
            $table->string("glucosa",45);
            $table->string("cetonas",45);
            $table->string("urobilinogeno",45);
            $table->string("bilirrubina",45);
            $table->string("sangre_enteros",45);
            $table->string("sangre_lisados",45);
            $table->string("acido_ascorbico",45);
            $table->string("hematies",45);
            $table->string("leucocitos",45);
            $table->string("cel_epiteliales",45);
            $table->string("fil_mucosos",45);
            $table->string("bacterias",45);
            $table->string("bacilos",45);
            $table->string("cristales",45);
            $table->string("cilindros",45);
            $table->string("piocitos",45);
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
        Schema::dropIfExists('examen_orina');
    }
}
