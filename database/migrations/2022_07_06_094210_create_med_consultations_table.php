<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('nur_id')->nullable()->default(null);//Establecemos null por el anterior backup
            $table->foreign('nur_id')->references('id')->on('nursing_area');
            $table->string('date',12);
            $table->string('hour',10);
            $table->string('consultationType',50);
            $table->string('reasonConsultation',500);
            $table->string('apparatusAndSystems',500);
            $table->string('physicalExploration',500);
            $table->string('laboratoryStudies',500);
            $table->string('diagnostic',500);
            $table->string('treatment',500);
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
        Schema::dropIfExists('med_consultations');
    }
}
