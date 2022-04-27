<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
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
            'identification_number'=>$this->faker->isbn10(),
            'name'=>$name,
            'lastname'=>$lastname,
            'fullname'=>$fullname,
            'speciality'=>$this->faker->randomElement(['Laboratista','Odontologo','Enfermero','Auxiliar de enfermería','Doctor']),
            'area'=>$this->faker->randomElement(['Laboratorio','Odontología','Enfermería'])
        ];
    }
}
