<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnfermeriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enfermeria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cita');
            $table->foreign('id_cita')->references('id')->on('citas');
            $table->decimal('peso',10,2)->default(0.00);
            $table->decimal('estatura',10,2)->default(0.00);
            $table->decimal('temperatura',10,2)->default(0.00);
            $table->string('presion',15)->default("");
            $table->char('enfermeria',1)->default("");
            $table->string('doctor',50)->default("");
            $table->string('terapia',30)->default("");
            $table->decimal('discapacidad',10,2)->default(0.00);
            $table->string('inyeccion',15)->default("");
            $table->string('curacion',15)->default("");
            $table->decimal('embarazo',10,2)->default(0.00);
            $table->string('enfermera',50)->default("");
            $table->string('cardiopatia',50)->default("");
            $table->string('diabetes',50)->default("");
            $table->string('hipertension',50)->default("");
            $table->string('cirugias',50)->default("");
            $table->string('alergias_medicina',50)->default("");
            $table->string('alergias_comida',50)->default("");
            $table->char('consultorio',1)->default("");
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
        Schema::dropIfExists('enfermeria');
    }
}
