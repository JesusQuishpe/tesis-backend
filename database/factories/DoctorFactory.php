<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cedula'=>$this->faker->isbn10(),
            'nombres'=>$this->faker->name(),
            'apellidos'=>$this->faker->lastName(),
            'area'=>$this->faker->randomElement(['Laboratorio','Odontología','Enfermería'])
        ];
    }
}
