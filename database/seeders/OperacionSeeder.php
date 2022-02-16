<?php

namespace Database\Seeders;

use App\Models\Operacion;
use Illuminate\Database\Seeder;

class OperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Crear
        $operacion=new Operacion();
        $operacion->nombre="Crear";
        $operacion->save();

        //Actualizar
        $operacion=new Operacion();
        $operacion->nombre="Actualizar";
        $operacion->save();

        //Eliminar
        $operacion=new Operacion();
        $operacion->nombre="Eliminar";
        $operacion->save();

        //Ver
        $operacion=new Operacion();
        $operacion->nombre="Ver";
        $operacion->save();
    }
}
