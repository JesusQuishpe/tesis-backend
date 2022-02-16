<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicesCpoCeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indices_cpo_ceo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontologia');
            $table->foreign('id_odontologia')->references('id')->on('odontologias');
            $table->float('c_d');
            $table->float('p_d');
            $table->float('o_d');
            $table->float('c_e');
            $table->float('e_e');
            $table->float('o_e');
            $table->float('total_cpo');
            $table->float('total_ceo');
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
        Schema::dropIfExists('indices_cpo_ceo');
    }
}
