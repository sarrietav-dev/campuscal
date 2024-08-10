<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Institution;
use App\Models\Requester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Requester>
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
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'identification' => $this->faker->randomNumber(),
            'institution_id' => Institution::factory(),
            'company_role' => $this->faker->jobTitle(),
            'academic_unit' => $this->faker->word(),
            'booking_id' => Booking::factory(),
        ];
    }
}
