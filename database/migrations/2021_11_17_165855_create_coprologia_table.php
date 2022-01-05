<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoprologiaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coprologia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cita");
            $table->foreign("id_cita")->references("id")->on("citas");
            $table->unsignedBigInteger("id_doc");
            $table->foreign("id_doc")->references("id")->on("doctores");
            $table->unsignedBigInteger("id_tipo");
            $table->foreign("id_tipo")->references("id")->on("tipo_examen");
            $table->string("consistencia",100);
            $table->string("moco",45);
            $table->string("sangre",45);
            $table->float("ph");
            $table->string("azucares_reductores",45);
            $table->string("levadura_y_micelos",45);
            $table->string("gram",100);
            $table->string("leucocitos",45);
            $table->string("polimorfonucleares",100);
            $table->string("mononucleares",100);
            $table->string("protozoarios",100);
            $table->string("helmintos",100);
            $table->string("esteatorrea",100);
            $table->string("observaciones",200);
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
        Schema::dropIfExists('coprologia');
    }
}
