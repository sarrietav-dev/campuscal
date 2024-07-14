<?php

namespace Database\Factories;

use App\Authorization\AppRoles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [])->afterCreating(function ($user) {
            $user->assignRole(AppRoles::ADMIN);
        });
    }

    public function requester(): static
    {
        return $this->state(fn () => [])->afterCreating(function ($user) {
            $user->assignRole(AppRoles::REQUESTER);
        });
    }

    public function superAdmin(): static
    {
        return $this->state(fn () => [])->afterCreating(function ($user) {
            $user->assignRole(AppRoles::SUPER_ADMIN);
        });
    }

    public function developer(): static
    {
        return $this->state(fn () => [])->afterCreating(function ($user) {
            $user->assignRole(AppRoles::DEVELOPER);
        });
    }
}
