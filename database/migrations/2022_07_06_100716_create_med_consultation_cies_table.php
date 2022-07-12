<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedConsultationCiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_consultation_cies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_id');
            $table->foreign('consultation_id')->references('id')->on('med_consultations');
            $table->unsignedBigInteger('cie_id');
            $table->foreign('cie_id')->references('id')->on('cies');
            $table->string('disease_state')->default("");
            $table->string('severity')->default("");
            $table->boolean('active_disease')->default(false);
            $table->boolean('infectious_disease')->default(false);
            $table->string('date',10)->nullable();
            $table->string('observations',500);
            $table->integer('diagnostic_age');
            $table->string('cured',50);
            $table->boolean('allergic_disease')->default(false);
            $table->string('allergy_type',50);
            $table->boolean('warnings_during_pregnancy')->default(false);
            $table->integer('week_contracted');
            $table->boolean('currently_in_treatment')->default(false);
            $table->string('aditional_information',500);
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
        Schema::dropIfExists('med_consultation_cies');
    }
}
