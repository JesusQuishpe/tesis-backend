<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedInterrogationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_interrogations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recordId');
            $table->foreign('recordId')->references('id')->on('medical_records');
            //Interrogatorio --------------------------
            $table->text('cardiovascular');
            $table->text('digestive');
            $table->text('endocrine');
            $table->text('hemolymphatic'); //hemolinfatico
            $table->text('mamas');
            $table->text('skeletalMuscle'); //musculo esqueletico
            $table->text('skinAndAnnexes'); //Piel y anexos
            $table->text('reproductive'); //Reproductor
            $table->text('respiratory'); //respiratorio
            $table->text('nervousSystem'); //sistema nervioso
            $table->text('generalSystems'); //sistemas generales
            $table->text('urinary'); //urninario
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
        Schema::dropIfExists('med_interrogations');
    }
}
