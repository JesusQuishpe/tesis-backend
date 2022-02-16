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
            $table->unsignedBigInteger("id_doc")->nullable()->default(null);
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->string("color",45)->default('')->default('');
            $table->string("olor",45)->default('');
            $table->string("sedimento",45)->default('');
            $table->float("ph")->default(0);
            $table->float("densidad")->default(0);
            $table->string("leucocituria",45)->default('');
            $table->string("nitritos",45)->default('');
            $table->string("albumina",45)->default('');
            $table->string("glucosa",45)->default('');
            $table->string("cetonas",45)->default('');
            $table->string("urobilinogeno",45)->default('');
            $table->string("bilirrubina",45)->default('');
            $table->string("sangre_enteros",45)->default('');
            $table->string("sangre_lisados",45)->default('');
            $table->string("acido_ascorbico",45)->default('');
            $table->string("hematies",45)->default('');
            $table->string("leucocitos",45)->default('');
            $table->string("cel_epiteliales",45)->default('');
            $table->string("fil_mucosos",45)->default('');
            $table->string("bacterias",45)->default('');
            $table->string("bacilos",45)->default('');
            $table->string("cristales",45)->default('');
            $table->string("cilindros",45)->default('');
            $table->string("piocitos",45)->default('');
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
        Schema::dropIfExists('examen_orina');
    }
}
