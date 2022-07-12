<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedPhysicalExplorationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_physical_explorations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recordId');
            $table->foreign('recordId')->references('id')->on('medical_records');
            //Exploracion fisica ----------------------
            $table->text('outerHabitus');//Habitus exterior
            $table->text('head');
            $table->text('eyes');
            $table->text('otorhinolaryngology');
            $table->text('neck');//cuello
            $table->text('chest');//abdomen
            $table->text('abdomen');
            $table->text('gynecologicalExamination');
            $table->text('genitals');
            $table->text('spine');//columna vertebral
            $table->text('extremities');
            $table->text('neurologicalExamination');//Exploracion neurologica
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
        Schema::dropIfExists('med_physical_explorations');
    }
}
