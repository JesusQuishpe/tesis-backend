<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rec_id');
            $table->foreign('rec_id')->references('id')->on('odo_patient_records');
            $table->string('per_disease',50);
            $table->string('bad_occlu',50);
            $table->string('fluorosis',50);
            $table->float('plaque_total')->default(0);
            $table->float('calc_total')->default(0);
            $table->float('gin_total')->default(0);
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
        Schema::dropIfExists('odo_indicators');
    }
}
