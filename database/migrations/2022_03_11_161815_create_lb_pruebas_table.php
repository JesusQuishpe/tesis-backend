<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLbPruebasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lb_pruebas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_grupo');
            $table->foreign('id_grupo')->references('id')->on('lb_grupos');
            $table->unsignedBigInteger('id_unidad');
            $table->foreign('id_unidad')->references('id')->on('lb_unidades');
            $table->string('codigo',20);
            $table->string('nombre',100);
            $table->string('valor_ref',1);
            $table->integer('de')->default(0);
            $table->integer('hasta')->default(0);
            $table->string('interpretacion',100)->default('');
            $table->string('valor_cualitativo',100)->default('');
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
        Schema::dropIfExists('lb_pruebas');
    }
}
