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
            $table->unsignedBigInteger('id_doc')->nullable()->default(null);
            $table->foreign('id_doc')->references('id')->on('doctores');
            $table->unsignedBigInteger('id_tipo');
            $table->foreign('id_tipo')->references('id')->on('tipo_examen');
            $table->float('glucosa')->default(0);
            $table->float('urea')->default(0);
            $table->float('creatinina')->default(0);
            $table->float('acido_urico')->default(0);
            $table->float('colesterol_total')->default(0);
            $table->float('colesterol_hdl')->default(0);
            $table->float('colesterol_ldl')->default(0);
            $table->float('trigliceridos')->default(0);
            $table->float('proteinas_totales')->default(0);
            $table->float('albumina')->default(0);
            $table->float('globulina')->default(0);
            $table->float('relacion_ag')->default(0);
            $table->float('bilirrubina_directa')->default(0);
            $table->float('bilirrubina_indirecta')->default(0);
            $table->float('bilirrubina_total')->default(0);
            $table->float('gamma_gt')->default(0);
            $table->float('calcio')->default(0);
            $table->float('transaminasa_ox')->default(0);
            $table->float('transaminasa_pir')->default(0);
            $table->float('fosfatasa_alcalina_adultos')->default(0);
            $table->float('fosfatasa_alcalina_ninos')->default(0);
            $table->float('amilasa')->default(0);
            $table->float('lipasa')->default(0);
            $table->string('vdrl',45)->default('');
            $table->string('proteinas_c_react',45)->default('');
            $table->string('ra_test_latex',45)->default('');
            $table->string('asto',45)->default('');
            $table->string('salmonella_o',45)->default('');
            $table->string('salmonella_h',45)->default('');
            $table->string('paratifica_a',45)->default('');
            $table->string('paratifica_b',45)->default('');
            $table->string('proteus_0x19',45)->default('');
            $table->string('proteus_0x2',45)->default('');
            $table->string('proteus_0xk',45)->default('');
            $table->string('observaciones',45)->default('');
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
        Schema::dropIfExists('bioquimica');
    }
}
