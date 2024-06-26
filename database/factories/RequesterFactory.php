<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requester>
 */
class RequesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "surname" => $this->faker->name(),
            "email" => $this->faker->email(),
            "phone" => $this->faker->phoneNumber(),
            "identification" => $this->faker->randomNumber(),
            "company_name" => $this->faker->company(),
            "company_role" => $this->faker->jobTitle(),
            "company_address" => $this->faker->address(),
            "academic_unit" => $this->faker->word(),
        ];
    }
}
