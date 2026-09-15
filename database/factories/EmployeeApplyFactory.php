<?php

namespace TomatoPHP\FilamentEmployees\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentEmployees\Models\EmployeeApply;

/**
 * @extends Factory<EmployeeApply>
 */
class EmployeeApplyFactory extends Factory
{
    protected $model = EmployeeApply::class;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'birthday' => $this->faker->dateTimeBetween('-45 years', '-20 years')->format('Y-m-d'),
            'id_type' => 'national',
            'id_number' => (string) $this->faker->unique()->numerify('##############'),
            'education_type' => 'university',
            'university' => $this->faker->company(),
            'position' => $this->faker->jobTitle(),
            'explicated_salary' => $this->faker->numberBetween(8, 30) * 1000,
            'status' => 'pending',
            'is_activated' => true,
        ];
    }
}
