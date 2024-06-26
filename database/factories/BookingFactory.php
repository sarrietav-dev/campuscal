<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Requester;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'details' => $this->faker->sentence(),
            'minors' => $this->faker->boolean(),
            'agreementContract' => $this->faker->boolean(),
            'assistance' => $this->faker->numberBetween(1, 200),
            'status' => $this->faker->randomElement(["pending", "approved", "rejected"]),
        ];
    }

    public function pending(): BookingFactory
    {
        return $this->state(fn(array $attributes) => ['status' => 'pending']);
    }

    public function approved(): BookingFactory
    {
        return $this->state(fn(array $attributes) => ['status' => 'approved']);
    }

    public function rejected(): BookingFactory
    {
        return $this->state(fn(array $attributes) => ['status' => 'rejected']);
    }
}
