<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'member_id' => \App\Models\Member::inRandomOrder()->first()->id,
            'staff_id' => \App\Models\Staff::inRandomOrder()->first()->id,
            'amount' => $this->faker->numberBetween(30, 300),
            'notes' => $this->faker->sentence(),
        ];
    }
}
