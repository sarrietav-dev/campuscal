<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<File>
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
        $url = 'https://picsum.photos/500/500?random=';

        return [
            'url' => $url.$this->faker->numberBetween(1, 100),
        ];
    }
}
