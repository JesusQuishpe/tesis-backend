<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedFamilyHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('med_family_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recordId');
            $table->foreign('recordId')->references('id')->on('medical_records');
            //Antecedentes ---------------------
            $table->text('pathological');
            $table->text('noPathological');
            $table->text('perinatal');
            $table->text('gynecological');
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
        Schema::dropIfExists('med_family_history');
    }
}
