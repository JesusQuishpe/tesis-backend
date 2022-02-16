<?php

namespace Database\Seeders;

use App\Models\Patologia;
use Illuminate\Database\Seeder;

class PatologiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pat=new Patologia();
        $pat->nombre="Labios";
        $pat->save();
        
        $pat=new Patologia();
        $pat->nombre="Mejillas";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Maxilar superior";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Maxilar inferior";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Lengua";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Paladar";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Piso";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Carrillos";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Glándulas salivales";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Oro faringe";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="A.T.M";
        $pat->save();

        $pat=new Patologia();
        $pat->nombre="Ganglios";
        $pat->save();
    }
}
