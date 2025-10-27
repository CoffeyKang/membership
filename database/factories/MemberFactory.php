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
            'member_id' => 'M' . $this->faker->unique()->numerify('###'),
            'full_name' => $this->faker->name('zh_CN'),
            'phone_number' => $this->faker->numerify('1##########'),
            'balance' => intval(round($this->faker->numberBetween(0, 2000) / 10) * 10),
        ];
    }
}
