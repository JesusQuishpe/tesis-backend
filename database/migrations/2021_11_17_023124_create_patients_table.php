<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('date',22);
            $table->string('identification_number',10)->unique();
            $table->string('lastname',50);
            $table->string('name',50);
            $table->string('fullname',100)->unique();
            $table->string('birth_date',12);
            $table->integer('age')->default(0);
            $table->string('gender',10);
            $table->string('cellphone_number',20);
            $table->string('address',150);
            $table->string('province',50);
            $table->string('city',50);
            $table->string('medical_history',10)->nullable()->default(null);
            $table->string('history_date',10)->nullable()->default(null);
            $table->string('statistics',1)->nullable()->default(null);
            //Para la parte del area de medicina
            $table->string('email',320)->default('');
            $table->string('notes',150)->default('');
            $table->string('occupation',150)->default('');
            $table->string('marital_status',100)->default('');//Estado civil
            $table->string('mother_name',100)->default('');
            $table->string('father_name',100)->default('');
            $table->string('origin',150)->default('');//Procedencia
            $table->string('couple_name',150)->default('');
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
        Schema::dropIfExists('patients');
    }
}
