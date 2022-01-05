<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBioquimicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bioquimica', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cita');
            $table->foreign('id_cita')->references('id')->on('citas');
            $table->unsignedBigInteger('id_doc');
            $table->foreign('id_doc')->references('id')->on('doctores');
            $table->unsignedBigInteger('id_tipo');
            $table->foreign('id_tipo')->references('id')->on('tipo_examen');
            $table->float('glucosa');
            $table->float('urea');
            $table->float('creatinina');
            $table->float('acido_urico');
            $table->float('colesterol_total');
            $table->float('colesterol_hdl');
            $table->float('colesterol_ldl');
            $table->float('trigliceridos');
            $table->float('proteinas_totales');
            $table->float('albumina');
            $table->float('globulina');
            $table->float('relacion_ag');
            $table->float('bilirrubina_directa');
            $table->float('bilirrubina_indirecta');
            $table->float('bilirrubina_total');
            $table->float('gamma_gt');
            $table->float('calcio');
            $table->float('transaminasa_ox');
            $table->float('transaminasa_pir');
            $table->float('fosfatasa_alcalina_adultos');
            $table->float('fosfatasa_alcalina_ninos');
            $table->float('amilasa');
            $table->float('lipasa');
            $table->string('vdrl',45);
            $table->string('proteinas_c_react',45);
            $table->string('ra_test_latex',45);
            $table->string('asto',45);
            $table->string('salmonella_o',45);
            $table->string('salmonella_h',45);
            $table->string('paratifica_a',45);
            $table->string('paratifica_b',45);
            $table->string('proteus_0x19',45);
            $table->string('proteus_0x2',45);
            $table->string('proteus_0xk',45);
            $table->string('observaciones',45);
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
        Schema::dropIfExists('bioquimica');
    }
}
