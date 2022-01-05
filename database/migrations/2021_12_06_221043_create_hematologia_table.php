<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHematologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hematologia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cita");
            $table->foreign("id_cita")->references("id")->on("citas");
            $table->unsignedBigInteger("id_doc");
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->float("sedimento");
            $table->float("hematocrito");
            $table->float("hemoglobina");
            $table->float("hematies");
            $table->float("leucocitos");
            $table->float("segmentados");
            $table->float("linfocitos");
            $table->float("eosinofilos");
            $table->float("monocitos");
            $table->string("t_coagulacion",45);
            $table->string("t_sangria",45);
            $table->float("t_plaquetas");
            $table->string("t_protombina_tp",45);
            $table->string("t_parcial_de_tromboplastine",45);
            $table->string("fibrinogeno",45);
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
        Schema::dropIfExists('hematologia');
    }
}
