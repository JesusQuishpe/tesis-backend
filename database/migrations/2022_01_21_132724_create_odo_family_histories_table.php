<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoFamilyHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_family_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rec_id');
            $table->foreign('rec_id')->references('id')->on('odo_patient_records');
            $table->string('description',300);
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
        Schema::dropIfExists('odo_family_histories');
    }
}
