<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model=Patient::class;
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
            'date'=>$this->faker->date(),
            'identification_number'=>$this->faker->isbn10(),
            'lastname'=>$lastname,
            'name'=>$name,
            'fullname'=>$fullname,
            'birth_date'=>$this->faker->date(),
            'gender'=>$this->faker->randomElement(['Masculino','Femenino']),
            'cellphone_number'=>$this->faker->phoneNumber(),
            'address'=>$this->faker->address(),
            'province'=>$this->faker->randomElement(['El Oro','Pichincha','Guayas','Manabí']),
            'city'=>$this->faker->randomElement(['Machala','Guayaquil','Quito','Cuenca','Esmeraldas']),
            //'medical_history'=>$this->faker->randomLetter(),
            //'history_date'=>$this->faker->date(),
            //'statistics'=>$this->faker->randomLetter()
        ];
    }
}
