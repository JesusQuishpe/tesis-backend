<?php

namespace Database\Seeders;

use App\Models\ModuloOperacion;
use Illuminate\Database\Seeder;

class ModuloOperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Modulo caja con las 4 operaciones(crear,actualizar,eliminar,ver)
        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 1;
        $moduloOperacion->id_operacion = 1;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 1;
        $moduloOperacion->id_operacion = 2;
        $moduloOperacion->save();
        
        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 1;
        $moduloOperacion->id_operacion = 3;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 1;
        $moduloOperacion->id_operacion = 4;
        $moduloOperacion->save();

        //Modulo enfermeria con las 4 operaciones(crear,actualizar,eliminar,ver)

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 2;
        $moduloOperacion->id_operacion = 1;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 2;
        $moduloOperacion->id_operacion = 2;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 2;
        $moduloOperacion->id_operacion = 3;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 2;
        $moduloOperacion->id_operacion = 4;
        $moduloOperacion->save();

        //Modulo medicina con las 4 operaciones(crear,actualizar,eliminar,ver)

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 3;
        $moduloOperacion->id_operacion = 1;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 3;
        $moduloOperacion->id_operacion = 2;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 3;
        $moduloOperacion->id_operacion = 3;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 3;
        $moduloOperacion->id_operacion = 4;
        $moduloOperacion->save();

        //Modulo odontologia con las 4 operaciones(crear,actualizar,eliminar,ver)

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 4;
        $moduloOperacion->id_operacion = 1;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 4;
        $moduloOperacion->id_operacion = 2;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 4;
        $moduloOperacion->id_operacion = 3;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 4;
        $moduloOperacion->id_operacion = 4;
        $moduloOperacion->save();

        //Modulo laboratorio con las 4 operaciones(crear,actualizar,eliminar,ver)

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 5;
        $moduloOperacion->id_operacion = 1;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 5;
        $moduloOperacion->id_operacion = 2;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 5;
        $moduloOperacion->id_operacion = 3;
        $moduloOperacion->save();

        $moduloOperacion = new ModuloOperacion();
        $moduloOperacion->id_modulo = 5;
        $moduloOperacion->id_operacion = 4;
        $moduloOperacion->save();

    }
}
