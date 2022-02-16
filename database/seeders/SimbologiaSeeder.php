<?php

namespace Database\Seeders;

use App\Models\Simbologia;
use Illuminate\Database\Seeder;

class SimbologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $simbologia=new Simbologia();
      $simbologia->nombre="Sellante necesario";
      $simbologia->path="sellante-necesario.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Sellante realizado";
      $simbologia->path="sellante-realizado.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Extracción indicada";
      $simbologia->path="extraccion-indicada.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Extracción indicada";
      $simbologia->path="extraccion-indicada.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Pérdida por caries";
      $simbologia->path="perdida-por-caries.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Pérdida otra causa";
      $simbologia->path="perdida-otra-causa.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Endodoncia";
      $simbologia->path="endodoncia.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Prótesis fija";
      $simbologia->path="protesis-fija.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Prótesis removible";
      $simbologia->path="protesis-removible.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Prótesis total";
      $simbologia->path="protesis-total.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Corona";
      $simbologia->path="corona.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Obturado";
      $simbologia->path="obturado.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Caries";
      $simbologia->path="caries.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();

      $simbologia=new Simbologia();
      $simbologia->nombre="Limpiar";
      $simbologia->path="clean.svg";
      $simbologia->tooltipDirection="top";
      $simbologia->save();
    }
}
