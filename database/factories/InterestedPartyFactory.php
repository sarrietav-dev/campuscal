<?php

namespace Database\Factories;

use App\Models\InterestedParty;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InterestedParty>
 */
class InterestedPartyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
