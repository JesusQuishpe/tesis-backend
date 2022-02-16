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
            $table->unsignedBigInteger('id_enfermeria');
            $table->foreign('id_enfermeria')->references('id')->on('enfermeria');
            //$table->tinyText('tipo');//INYTEXT: 255 characters - 255 B.
            //$table->tinyText('valor');
            $table->string('sintoma1');
            $table->string('sintoma2');
            $table->string('sintoma3');
            $table->string('presuntivo1');
            $table->string('presuntivo2');
            $table->string('presuntivo3');
            $table->string('definitivo1');
            $table->string('definitivo2');
            $table->string('definitivo3');
            $table->string('medicamento1');
            $table->string('medicamento2');
            $table->string('medicamento3');
            $table->string('medicamento4');
            $table->string('medicamento5');
            $table->string('medicamento6');
            $table->string('dosificacion1');
            $table->string('dosificacion2');
            $table->string('dosificacion3');
            $table->string('dosificacion4');
            $table->string('dosificacion5');
            $table->string('dosificacion6');
            $table->boolean('atendido')->default(false);
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
