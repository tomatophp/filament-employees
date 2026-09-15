<?php

namespace TomatoPHP\FilamentEmployees\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentEmployees\Models\AttendanceShift;

/**
 * @extends Factory<AttendanceShift>
 */
class AttendanceShiftFactory extends Factory
{
    protected $model = AttendanceShift::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'type' => 'master',
            'start_at' => '09:00:00',
            'end_at' => '17:00:00',
            'offs' => [
                ['start_at' => 'fri'],
            ],
            'is_activated' => true,
        ];
    }
}
