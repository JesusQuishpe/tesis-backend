<?php

namespace Database\Seeders;

use App\Models\Diente;
use Illuminate\Database\Seeder;

class DienteSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //Primer cuadrante(Derecho)
    $cuadrante = 1;
    for ($i = 8; $i >= 1; $i--) {
      $diente = new Diente();
      $diente->tipo = "Vestibular";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 2;
    for ($i = 1; $i <= 8; $i++) {
      $diente = new Diente();
      $diente->tipo = "Vestibular";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 3;
    for ($i = 1; $i <=8; $i++) {
      $diente = new Diente();
      $diente->tipo = "Vestibular";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 4;
    for ($i = 8; $i >=1; $i--) {
      $diente = new Diente();
      $diente->tipo = "Vestibular";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }


    //Liguales
    $cuadrante = 5;
    for ($i = 5; $i >= 1; $i--) {
      $diente = new Diente();
      $diente->tipo = "Lingual";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 6;
    for ($i = 1; $i <= 5; $i++) {
      $diente = new Diente();
      $diente->tipo = "Lingual";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 7;
    for ($i = 1; $i <= 5; $i++) {
      $diente = new Diente();
      $diente->tipo = "Lingual";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

    $cuadrante = 8;
    for ($i = 5; $i >=1; $i--) {
      $diente = new Diente();
      $diente->tipo = "Lingual";
      $diente->cuadrante = $cuadrante;
      $diente->numDiente = $i;
      $diente->piezaDental = strval($cuadrante) . strval($i);
      $diente->save();
    }

  }
}
