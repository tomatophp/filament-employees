<?php

namespace TomatoPHP\FilamentEmployees\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use TomatoPHP\FilamentEmployees\Tests\Models\Account;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    public function definition(): array
    {
        $email = $this->faker->unique()->safeEmail();

        return [
            'name' => $this->faker->name(),
            'type' => 'employee',
            'address' => $this->faker->address(),
            'phone' => $this->faker->unique()->e164PhoneNumber(),
            'email' => $email,
            'username' => $email,
            'loginBy' => 'email',
            'password' => Hash::make('password'),
            'is_active' => true,
        ];
    }
}
