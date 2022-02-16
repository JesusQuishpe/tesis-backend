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
        $name=$this->faker->name();
        $lastname=$this->faker->lastName();
        $fullname=$name.' '.$lastname;
        return [
            'cedula'=>$this->faker->isbn10(),
            'nombres'=>$name,
            'apellidos'=>$lastname,
            'nombre_completo'=>$fullname,
            'area'=>$this->faker->randomElement(['Laboratorio','Odontología','Enfermería'])
        ];
    }
}
