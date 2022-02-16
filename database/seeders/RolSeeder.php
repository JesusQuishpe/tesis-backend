<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $rol=new Rol();
        $rol->nombre='Administrador';
        $rol->save();

        $rol=new Rol();
        $rol->nombre='Cajero';
        $rol->save();

        $rol=new Rol();
        $rol->nombre='Enfermero';
        $rol->save();

        $rol=new Rol();
        $rol->nombre='Odontologo';
        $rol->save();
        
        $rol=new Rol();
        $rol->nombre='Laboratista';
        $rol->save();
    }
}
