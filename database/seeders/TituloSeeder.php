<?php

namespace Database\Seeders;

use App\Models\Titulo;
use Illuminate\Database\Seeder;

class TituloSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $titulo = new Titulo();
    $titulo->nombre = "FISICO QUIMICO";
    $titulo->save();

    $titulo = new Titulo();
    $titulo->nombre = "MICROSCOPIO";
    $titulo->save();

    
  }
}
