<?php

namespace Database\Seeders;

use App\Models\Antecedente;
use Illuminate\Database\Seeder;

class AntecedenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ant=new Antecedente();
        $ant->nombre="Alergia antibiótico";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Alergia anestesia";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Hemorragias superior";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="vih/sida";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Tuberculosis";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Asma";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Diabetes";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Hipertensión";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Enf. cardiaca";
        $ant->save();

        $ant=new Antecedente();
        $ant->nombre="Otro";
        $ant->save();
    }
}
