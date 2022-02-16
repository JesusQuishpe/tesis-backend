<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamenEstomatogmaticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('examen_estomatogmatico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_odontologia');
            $table->foreign('id_odontologia')->references('id')->on('odontologias');
            $table->string('descripcion',300);
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
        Schema::dropIfExists('examen_estomatogmatico');
    }
}
