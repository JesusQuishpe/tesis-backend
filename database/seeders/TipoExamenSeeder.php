<?php

namespace Database\Seeders;

use App\Models\TipoExamen;
use Illuminate\Database\Seeder;

class TipoExamenSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Individual";
        $tipoExamen->save();


        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Parámetro";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Perfil";
        $tipoExamen->save();

        /*$tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Bioquímica Sanguínea";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Coprología para EDA";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Coproparasitario";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Examen de orina";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="HelicoBacter Pylori IgG Heces";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="HelicoBacter Pylori IgG";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Hematología";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Hemoglobina glicosilada";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Prueba de embarazo";
        $tipoExamen->save();

        $tipoExamen=new TipoExamen();
        $tipoExamen->nombre="Pruebas tiroideas";
        $tipoExamen->save();*/

    }
}
