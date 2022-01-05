<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicina', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cita');
            $table->foreign('id_cita')->references('id')->on('citas');
            $table->tinyText('tipo');//INYTEXT: 255 characters - 255 B.
            $table->tinyText('valor');
            $table->tinyText('sintoma1');
            $table->tinyText('sintoma2');
            $table->tinyText('sintoma3');
            $table->tinyText('presuntivo1');
            $table->tinyText('presuntivo2');
            $table->tinyText('presuntivo3');
            $table->tinyText('definitivo1');
            $table->tinyText('definitivo2');
            $table->tinyText('definitivo3');
            $table->tinyText('medicamento1');
            $table->tinyText('medicamento2');
            $table->tinyText('medicamento3');
            $table->tinyText('medicamento4');
            $table->tinyText('medicamento5');
            $table->tinyText('medicamento6');
            $table->tinyText('dosificacion1');
            $table->tinyText('dosificacion2');
            $table->tinyText('dosificacion3');
            $table->tinyText('dosificacion4');
            $table->tinyText('dosificacion5');
            $table->tinyText('dosificacion6');
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
        Schema::dropIfExists('medicina');
    }
}
