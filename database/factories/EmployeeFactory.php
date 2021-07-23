<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
      'name'=>$faker->name,
      'email'=>$faker->email,
      'phone'=>$faker->phoneNumber,
      'address'=>$faker->address
        ];
    }
}
