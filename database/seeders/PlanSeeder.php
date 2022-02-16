<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan=new Plan();
        $plan->nombre="Biometría";
        $plan->save();

        $plan=new Plan();
        $plan->nombre="Química sanguínea";
        $plan->save();

        $plan=new Plan();
        $plan->nombre="Rayos x";
        $plan->save();

        $plan=new Plan();
        $plan->nombre="Otros";
        $plan->save();
        
    }
}
