<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CitaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fecha_cita'=>$this->faker->date(),
            'hora_cita'=>$this->faker->date("H:i:s"),
            'cedula_cita'=>$this->faker->isbn10(),
            'area'=>$this->faker->randomElement(['Laboratorio','Enfermería','Odontología']),
            'valor'=>$this->faker->randomNumber(4),
            'factura_cita'=>$this->faker->text(10),
            'estado_cita'=>$this->faker->randomLetter(),
            'id_paciente'=>$this->faker->randomNumber(1),
            'estadisticas'=>$this->faker->randomLetter(),

        ];
    }
}
