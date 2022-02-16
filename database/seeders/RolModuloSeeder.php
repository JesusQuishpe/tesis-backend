<?php

namespace Database\Seeders;

use App\Models\RolModulo;
use Illuminate\Database\Seeder;

class RolModuloSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //Permiso a modulo de caja
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 1;
    $rolModulo->checked = true;
    $rolModulo->save();

    /*$rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 7;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 8;
    $rolModulo->checked = true;
    $rolModulo->save();*/

    //Permiso modulo de Enfermeria
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 2;
    $rolModulo->checked = true;
    $rolModulo->save();

    //Permiso modulo de medicina
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 3;
    $rolModulo->checked = true;
    $rolModulo->save();

    
   /* $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 9;
    $rolModulo->checked = true;
    $rolModulo->save();


    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 10;
    $rolModulo->checked = true;
    $rolModulo->save();*/

    //Permiso modulo odontologia
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 4;
    $rolModulo->checked = true;
    $rolModulo->save();

    /*$rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 11;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 12;
    $rolModulo->checked = true;
    $rolModulo->save();*/

    //Modulo laboratorio
    //Modulo padre
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 5;
    $rolModulo->checked = true;
    $rolModulo->save();
    //Submodulos
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 7;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 8;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 9;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 10;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 11;
    $rolModulo->checked = true;
    $rolModulo->save();
    //Modulo de mantenimiento
    //Modulo padre
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 6;
    $rolModulo->checked = true;
    $rolModulo->save();

    //Submodulos
    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 12;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 13;
    $rolModulo->checked = true;
    $rolModulo->save();

    $rolModulo = new RolModulo();
    $rolModulo->id_rol = 1;
    $rolModulo->id_modulo = 14;
    $rolModulo->checked = true;
    $rolModulo->save();
  }
}
