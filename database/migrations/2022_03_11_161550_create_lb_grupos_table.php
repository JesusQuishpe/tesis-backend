<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_grupos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_area');
            $table->foreign('id_area')->references('id')->on('lb_areas');
            $table->string('codigo',20);
            $table->string('nombre',100);
            $table->boolean('mostrarEnImpresion')->default(false);
            $table->float('costo')->default(0);
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
        Schema::dropIfExists('lb_grupos');
    }
}
