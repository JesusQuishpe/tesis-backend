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
            $table->unsignedBigInteger("id_doc")->nullable()->default(null);
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->float("sedimento")->default(0);
            $table->float("hematocrito")->default(0);
            $table->float("hemoglobina")->default(0);
            $table->float("hematies")->default(0);
            $table->float("leucocitos")->default(0);
            $table->float("segmentados")->default(0);
            $table->float("linfocitos")->default(0);
            $table->float("eosinofilos")->default(0);
            $table->float("monocitos")->default(0);
            $table->string("t_coagulacion",45)->default('');
            $table->string("t_sangria",45)->default('');
            $table->float("t_plaquetas")->default(0);
            $table->string("t_protombina_tp",45)->default('');
            $table->string("t_parcial_de_tromboplastine",45)->default('');
            $table->string("fibrinogeno",45)->default('');
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
        Schema::dropIfExists('hematologia');
    }
}
