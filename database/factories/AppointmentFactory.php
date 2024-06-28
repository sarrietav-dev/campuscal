<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Space;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_start' => $this->faker->dateTime(),
            'date_end' => $this->faker->dateTime(),
            'space_id' => Space::factory(),
            'booking_id' => Booking::factory(),
        ];
    }
}
