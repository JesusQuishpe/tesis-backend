<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $menu = new Menu();
    $menu->nombre = "Caja";
    $menu->path = "/caja";
    $menu->save();

    $menu = new Menu();
    $menu->nombre = "Enfermeria";
    $menu->path = "/enfermeria";
    $menu->save();

    $menu = new Menu();
    $menu->nombre = "Medicina";
    $menu->path = "/medicina";
    $menu->save();

    $menu = new Menu();
    $menu->nombre = "Odontoloia";
    $menu->path = "/odontologia";
    $menu->save();

    $menu = new Menu();
    $menu->nombre = "Caja";
    $menu->path = "/caja";
    $menu->save();

    $menu = new Menu();
    $menu->nombre = "Caja";
    $menu->path = "/caja";
    $menu->save();
  }
}
