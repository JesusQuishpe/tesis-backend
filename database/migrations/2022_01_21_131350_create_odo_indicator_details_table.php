<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdoIndicatorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odo_indicator_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ind');
            $table->foreign('id_ind')->references('id')->on('odo_indicators');
            $table->boolean('piece1')->default(false);
            $table->boolean('piece2')->default(false);
            $table->boolean('piece3')->default(false);
            $table->integer('plaque')->nullable()->default(0);
            $table->integer('calc')->nullable()->default(0);
            $table->integer('gin')->nullable()->default(0);
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
        Schema::dropIfExists('odo_indicator_details');
    }
}
