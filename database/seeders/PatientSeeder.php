<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Patient::factory(10)->create();
        $patient=new Patient();
        $patient->identification_number="0804505881";
        $patient->name="Jesús Alberto";
        $patient->lastname="Quishpe Granda";
        $patient->fullname="Jesús Alberto Quishpe Granda";
        $patient->birth_date="1999-07-17";
        $patient->gender="Masculino";
        $patient->cellphone_number="0963933794";
        $patient->address="Ciudadela la primavera";
        $patient->city="Machala";
        $patient->province="El Oro";
        $patient->date="2022-04-13";
        $patient->save();
    }
}
