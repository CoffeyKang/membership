<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name('zh_CN'),
            'phone_number' => $this->faker->numerify('1##########'),
            'balance' => 0,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($member) {
            $count = rand(1, 5);
            for ($i = 0; $i < $count; $i++) {
                $member->depositHistories()->create([
                    'amount' => intval(round($this->faker->numberBetween(10, 500) / 10) * 10),
                    'type' => $this->faker->randomElement([0, 1, 2, 3]),
                    'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
                ]);
            }
            $member->balance = $member->depositHistories()->sum('amount');
            $member->save();
        });
    }
}
