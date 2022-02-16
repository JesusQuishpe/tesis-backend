<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('id_parent')->nullable();
            $table->string('path')->nullable();
            $table->boolean('enable')->default(false);
            $table->boolean('canDelete')->default(false);
            $table->string('url')->nullable();
            $table->timestamps();
        });

        Schema::table('modulos', function (Blueprint $table) {
            $table->foreign('id_parent')->references('id')->on('modulos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
