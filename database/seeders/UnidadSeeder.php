<?php

namespace Database\Seeders;

use App\Models\Unidad;
use Illuminate\Database\Seeder;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidad=new Unidad();
        $unidad->nombre="Gramos por decilitro";
        $unidad->abreviatura="g/dL";
        $unidad->save();

        $unidad=new Unidad();
        $unidad->nombre="Gramos por litro";
        $unidad->abreviatura="g/L";
        $unidad->save();

        $unidad=new Unidad();
        $unidad->nombre="Microlitros";
        $unidad->abreviatura="mcL";
        $unidad->save();

        $unidad=new Unidad();
        $unidad->nombre="Miligramos por decilitro";
        $unidad->abreviatura="mg/dL";
        $unidad->save();
    }
}