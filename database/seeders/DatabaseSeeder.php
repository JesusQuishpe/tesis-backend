<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        $this->call(PacienteSeeder::class);
        $this->call(DoctorSeeder::class);
        $this->call(TipoExamenSeeder::class);
        $this->call(PatologiaSeeder::class);
        $this->call(AntecedenteSeeder::class);
        $this->call(ModuloSeeder::class);
        $this->call(RolSeeder::class);
        //$this->call(OperacionSeeder::class);
        $this->call(RolModuloSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(DienteSeeder::class);
        $this->call(SimbologiaSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(TituloSeeder::class);
        $this->call(EstudioSeeder::class);
        //$this->call(ModuloOperacionSeeder::class);
        //$this->call(CitaSeeder::class);
    }
}
