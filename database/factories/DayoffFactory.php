<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dayoff>
 */
class DayoffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $staff_id = Staff::activeStaff()->notLeft()->inRandomOrder()->first()->id;

        return [
            'staff_id' => $staff_id,
            'date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_archived' => false,
        ];
    }
}
