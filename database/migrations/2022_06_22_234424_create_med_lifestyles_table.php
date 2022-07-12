<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedLifestylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_lifestyles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recordId');
            $table->foreign('recordId')->references('id')->on('medical_records');
            //Actividad Fisica ---------------------------
            $table->boolean('doExercise')->default(0);
            $table->integer('minPerDay')->default(0);
            $table->boolean('doSport')->default(0);
            $table->string('sportDescription',200)->default('');
            $table->string('sportFrequency',200)->default('');
            $table->boolean('sleep')->default(0);
            $table->integer('sleepHours')->default(0);
            //Tabaquismo
            $table->boolean('smoke')->default(0);
            $table->integer('startSmokingAge')->default(0);
            $table->boolean('formerSmoker')->default(0);
            $table->integer('cigarsPerDay')->default(0);
            $table->boolean('passiveSmoker')->default(0);
            $table->integer('stopSmokingAge')->default(0);
            //Habitos alimenticios
            $table->boolean('breakfast')->default(0);
            $table->integer('mealsPerDay')->default(0);
            $table->boolean('drinkCoffe')->default(0);
            $table->integer('cupsPerDay')->default(0);
            $table->boolean('drinkSoda')->default(0);
            $table->boolean('doDiet')->default(0);
            $table->string('dietDescription',200)->default('');
            //Otros
            $table->boolean('workAuthonomy')->default(0);//Autonomia en el trabajo
            $table->string('workShift',200)->default('');//Turno en el trabajo
            $table->string('hobbies',300)->default('');//Actividades que realiza en tiempos libres
            $table->string('otherSituations',300)->default('');
            //Consumo de drogas
            $table->boolean('takeDrugs')->default(0);//Consume drogas
            $table->boolean('formerAddict')->default(0);
            $table->integer('startAgeConsume')->default(0);
            $table->integer('stopAgeConsume')->default(0);
            $table->boolean('ivDrugs')->default(0);//Droga intravenosa
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
        Schema::dropIfExists('med_lifestyles');
    }
}
