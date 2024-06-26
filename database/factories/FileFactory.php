<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $url = "https://picsum.photos/500/500?random=";

        return [
            "path" => $url . $this->faker->numberBetween(1, 100),
            "name" => $this->faker->word(),
            "type" => $this->faker->mimeType(),
        ];
    }
}